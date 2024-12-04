<?php

namespace Database\Seeders;

use App\Models\Author;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Author::insert([
            ['name' => 'John Doe', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Jane Doe', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'John Smith', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Jane Smith', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'John Johnson', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Jane Johnson', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'John Williams', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Jane Williams', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'John Brown', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Jane Brown', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
