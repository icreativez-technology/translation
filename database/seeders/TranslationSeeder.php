<?php

namespace Database\Seeders;

use App\Models\Translation;
use App\Models\TranslationTag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TranslationSeeder extends Seeder
{
    private array $locales = ['en', 'fr', 'es', 'de', 'it', 'pt', 'ru', 'zh', 'ja', 'ar'];
    private array $groups = ['web', 'mobile', 'desktop'];
    private array $tags = ['ui', 'button', 'header', 'footer', 'notification', 'form', 'table', 'modal'];

    public function run()
    {
        // Disable query logging for performance
        DB::disableQueryLog();

        // Create translations in batches for better performance
        $totalRecords = 100000;
        $batchSize = 5000;
        $batches = ceil($totalRecords / $batchSize);

        $this->command->info("Starting to seed {$totalRecords} translations...");
        $progressBar = $this->command->getOutput()->createProgressBar($batches);

        for ($i = 0; $i < $batches; $i++) {
            $this->createBatch($batchSize);
            $progressBar->advance();
        }

        $progressBar->finish();
        $this->command->newLine();
        $this->command->info("Successfully seeded {$totalRecords} translations.");
    }

    private function createBatch(int $batchSize): void
    {
        $translations = [];
        $translationTags = [];
        $now = now();

        for ($j = 0; $j < $batchSize; $j++) {
            $group = $this->groups[array_rand($this->groups)];
            $key = Str::slug(Str::random(10));
            $locale = $this->locales[array_rand($this->locales)];
            $value = "Translation for {$key} in {$locale} - " . Str::random(20);

            $translation = [
                'group' => $group,
                'key' => $key,
                'value' => $value,
                'locale' => $locale,
                'created_at' => $now,
                'updated_at' => $now,
            ];

            $translations[] = $translation;
        }

        // Insert translations and get their IDs
        DB::table('translations')->insert($translations);

        // Get the last inserted IDs
        $lastId = DB::getPdo()->lastInsertId();
        $translationIds = range($lastId, $lastId + $batchSize - 1);

        // Create tags for each translation
        foreach ($translationIds as $translationId) {
            $numTags = rand(1, 3);
            $selectedTags = array_rand(array_flip($this->tags), $numTags);

            foreach ((array)$selectedTags as $tag) {
                $translationTags[] = [
                    'translation_id' => $translationId,
                    'tag' => $tag,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
        }

        // Insert tags in batches
        foreach (array_chunk($translationTags, 1000) as $chunk) {
            DB::table('translation_tags')->insert($chunk);
        }
    }
}