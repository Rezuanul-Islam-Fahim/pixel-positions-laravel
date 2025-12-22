<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagsController extends Controller
{
    public function __invoke(Request $request, Tag $tag)
    {
        return view('tags', ['jobs' => $tag->jobs]);
    }
}
