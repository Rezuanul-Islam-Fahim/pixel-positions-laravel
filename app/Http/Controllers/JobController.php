<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Tag;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function index()
    {
        $jobs = Job::all();
        $tags = Tag::all();

        return view('jobs.index', [
            'jobs' => $jobs,
            'tags' => $tags,
        ]);
    }
}
