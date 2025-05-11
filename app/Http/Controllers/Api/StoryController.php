<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Story;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StoryController extends Controller
{
    public function index(): JsonResponse
    {
        try {
            $stories = Story::with(['chapters' => function($query) {
                $query->orderBy('chapter_number')->first();
            }])->get();

            return response()->json([
                'success' => true,
                'data' => $stories->map(function($story) {
                    return [
                        'id' => $story->id,
                        'title' => $story->title,
                        'description' => $story->summary,
                        'available' => true,
                        'first_chapter' => $story->chapters->first()
                    ];
                })
            ]);
        } catch (\Exception $e) {
            \Log::error('Error loading stories: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error loading stories'
            ], 500);
        }
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
