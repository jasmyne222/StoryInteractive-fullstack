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
            \Log::info('Attempting to fetch stories');
            
            $stories = Story::all();
            
            \Log::info('Found ' . $stories->count() . ' stories');

            $formattedStories = $stories->map(function($story) {
                return [
                    'id' => $story->id,
                    'title' => $story->title,
                    'description' => $story->summary,
                    'available' => true
                ];
            });

            \Log::info('Formatted stories data:', $formattedStories->toArray());

            return response()->json([
                'success' => true,
                'data' => $formattedStories
            ]);

        } catch (\Exception $e) {
            \Log::error('Error in stories index: ' . $e->getMessage());
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
