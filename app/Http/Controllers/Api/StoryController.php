<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Story;

class StoryController extends Controller
{
    public function index()
    {
        $stories = Story::all(['id', 'title', 'summary']);
        return response()->json([
            'success' => true,
            'data' => $stories
        ]);
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
