<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\WorkPlace;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WorkPlaceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        WorkPlace::factory()
            ->count(5)
            ->hasWorkers(fake()->numberBetween(1, 3))
            ->create();
    }
}
