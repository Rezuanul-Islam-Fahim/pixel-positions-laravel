<?php

namespace Database\Seeders;

use App\Models\Job;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class JobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Job::factory(20)->create();

        // Job::factory(20)->create(new Sequence([
        //     'featured' => false,
        //     'schedule' => 'Full Time',
        // ], [
        //     'featured' => true,
        //     'schedule' => 'Part Time'
        // ]));
    }
}
