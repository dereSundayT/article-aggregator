<?php

namespace Database\Seeders;

use App\Models\Source;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Crypt;

class SourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Source::insert([
            [
                'name' => 'NewsAPI',
                'api_url'=>config('app.news_api_url'),
                'api_key'=>Crypt::encrypt(config('app.news_api_token')),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'The Guardian',
                'api_url'=>config('app.guardian_api_url'),
                'api_key'=>Crypt::encrypt(config('app.guardian_api_token')),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'New York Times',
                'api_url'=>config('app.the_new_york_time_api_url'),
                'api_key'=>Crypt::encrypt(config('app.the_new_york_time_api_token')),
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
