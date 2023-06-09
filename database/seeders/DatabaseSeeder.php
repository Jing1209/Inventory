<?php

namespace Database\Seeders;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Building::factory(15)->create();
        // \App\Models\Employee::factory(20)->create();
        \App\Models\Sponsor::factory(10)->create();
        // \App\Models\Category::factory(5)->create();
        $this->call(UserSeeder::class);
    }
}
