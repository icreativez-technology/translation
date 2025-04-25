<?php

namespace App\Http\Controllers\API;

use App\Models\Translation;
use App\Models\TranslationTag;
use Illuminate\Http\Request;
use App\Http\Requests\StoreTranslationRequest;
use App\Http\Requests\UpdateTranslationRequest;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class TranslationController extends Controller
{

    public function create()
    {
        $query = "
            (SELECT 'locale' AS type, locale AS value FROM translations GROUP BY locale ORDER BY locale)
            UNION ALL
            (SELECT 'group' AS type, `group` AS value FROM translations GROUP BY `group` ORDER BY `group`)
            UNION ALL
            (SELECT 'tag' AS type, tag AS value FROM translation_tags GROUP BY tag ORDER BY tag)
        ";
    
        $results = DB::select($query);
    
        $data = [
            'locales' => [],
            'groups' => [],
            'tags' => [],
        ];
    
        foreach ($results as $row) {
            $data[$row->type.'s'][] = $row->value;
        }
    
        return Inertia::render('Translations/Create', [
            'locales' => $data['locales'],
            'groups' => $data['groups'],
            'allTags' => $data['tags'],
        ]);
    }


    public function index(Request $request)
    {
        $validated = $request->validate([
            'search' => 'nullable|string|max:255',
            'locale' => 'nullable|string|size:2',
            'group' => 'nullable|string|max:50',
            'tag' => 'nullable|string|max:50',
            'page' => 'nullable|integer|min:1',
        ]);
    
      
        $query = Translation::with(['tags' => function ($query) use ($validated) {
                if (!empty($validated['tag'])) {
                    $query->where('tag', $validated['tag']);
                }
            }])
            ->when(!empty($validated['search']), function ($query) use ($validated) {
                $query->where(function($q) use ($validated) {
                    $q->where('key', 'like', "%{$validated['search']}%")
                      ->orWhere('value', 'like', "%{$validated['search']}%");
                });
            })
            ->when(!empty($validated['locale']), fn ($q) => $q->where('locale', $validated['locale']))
            ->when(!empty($validated['group']), fn ($q) => $q->where('group', $validated['group']));
    
       
        $filterOptions = [
            'locales' => Translation::distinct('locale')->orderBy('locale')->pluck('locale'),
            'groups' => Translation::distinct('group')->orderBy('group')->pluck('group'),
            'tags' => TranslationTag::distinct('tag')->orderBy('tag')->pluck('tag'),
        ];
    
       
        $translations = $query->paginate(10)
            ->withQueryString();
    
        return Inertia::render('Translations/Index', [
            'translations' => $translations,
            'filters' => $validated,
            ...$filterOptions,
        ]);
    }
    
    
    public function store(StoreTranslationRequest $request)
    {
        $translation = Translation::create($request->validated());
        
        if ($request->has('tags')) {
            foreach ($request->tags as $tag) {
                $translation->tags()->create(['tag' => $tag]);
            }
        }
        
        return redirect()->route('translations.index')->with('success', 'Translation created successfully');
    }
    
    public function show(Translation $translation)
    {
        return Inertia::render('Translations/Show', [
            'translation' => $translation->load('tags')
        ]);
    }

    public function edit($id)
    {
        $translation = Translation::with('tags')->findOrFail($id);

        $query = "
            (SELECT 'locale' AS type, locale AS value FROM translations GROUP BY locale ORDER BY locale)
            UNION ALL
            (SELECT 'group' AS type, `group` AS value FROM translations GROUP BY `group` ORDER BY `group`)
            UNION ALL
            (SELECT 'tag' AS type, tag AS value FROM translation_tags GROUP BY tag ORDER BY tag)
        ";
    
        $results = DB::select($query);
    
        $data = [
            'locales' => [],
            'groups' => [],
            'tags' => [],
        ];

        foreach ($results as $row) {
            $data[$row->type.'s'][] = $row->value;
        }
    

        return Inertia::render('Translations/Edit', [
            'translation' => $translation,
            'locales'     => $data['locales'],
            'groups'      => $data['groups'],
            'tags'        => $data['tags']
        ]);
    }
    
    public function update(UpdateTranslationRequest $request, Translation $translation)
    {
        $translation->update($request->validated());
        
        if ($request->has('tags')) {
            $translation->tags()->delete();
            foreach ($request->tags as $tag) {
                $translation->tags()->create(['tag' => $tag]);
            }
        }
        
        return redirect()->back()->with('success', 'Translation updated successfully');
    }
    
    
    public function export()
    {
       
        $translations = Cache::remember('translations_export', now()->addHour(), function() {
            return Translation::all()
                ->groupBy('locale')
                ->map(function($items) {
                    return $items->groupBy('group')
                        ->map(function($groupItems) {
                            return $groupItems->pluck('value', 'key');
                        });
                });
        });
        
        return Inertia::render('Translations/Export', [
            'exportData' => $translations
        ]);
    }
    
}