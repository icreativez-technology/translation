<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TranslationGroup extends Model
{
    protected $fillable = ['key'];

    public function translations(): HasMany
    {
        return $this->hasMany(Translation::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'translation_tag', 'translation_id', 'tag_id')
            ->withPivot('translation_id');
    }
}
