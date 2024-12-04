<?php

namespace Database\Seeders;

use App\Models\Source;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

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
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'OpenNews',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'NewsCred:',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
