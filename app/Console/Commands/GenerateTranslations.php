<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Database\Seeders\TranslationSeeder;
use Illuminate\Support\Facades\Artisan;

class GenerateTranslations extends Command
{
    protected $signature = 'translations:seed 
    {--count=100000 : Number of translations to create} 
    {--batch=5000 : Batch size for insertion}';

        protected $description = 'Seed the database with a large number of translation records';

        public function handle()
        {
        $count = (int)$this->option('count');
        $batchSize = (int)$this->option('batch');

        config(['database.seeder.total_translations' => $count]);
        config(['database.seeder.batch_size' => $batchSize]);

        $this->info("Seeding {$count} translations in batches of {$batchSize}...");

        $start = microtime(true);

        Artisan::call('db:seed', [
        '--class' => 'TranslationSeeder',
        '--force' => true,
        ]);

        $duration = round(microtime(true) - $start, 2);
        $this->info("Completed in {$duration} seconds.");
        }

}

