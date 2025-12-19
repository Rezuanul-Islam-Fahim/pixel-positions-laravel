<?php

namespace Database\Seeders;

use App\Models\Job;
use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = Tag::factory(50)->create();

        Job::all()->each(function (Job $job) use ($tags) {
            $job->tags()->attach(
                $tags->random(rand(1, 4))
            );
        });
    }
}
