<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Story;

class StoryController extends Controller
{
    public function index()
    {
        return response()->json(Story::all(['id', 'title', 'summary']));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $story = Story::create([
            'title' => $request->input('title'),
            'summary' => $request->input('summary'),
        ]);
    
        return response()->json($story, 201);
    }
}
