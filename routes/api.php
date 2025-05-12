<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\StoryController;
use App\Http\Controllers\Api\ChapterController;
use App\Http\Controllers\Api\ChoiceController;
use App\Http\Controllers\Api\ProgressController;
use Illuminate\Http\Request;

Route::prefix('v1')->group(function () {
    // Routes publiques
    Route::get('stories', [StoryController::class, 'index']);
    Route::get('stories/{id}', [StoryController::class, 'show']);
    Route::get('stories/{id}/first-chapter', [ChapterController::class, 'firstChapter']); // Ajout de cette ligne
    Route::get('chapters/{id}', [ChapterController::class, 'show']);
    Route::get('chapters/{chapterId}/choices', [ChoiceController::class, 'index']);

    // Routes protégées
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('user', function (Request $request) {
            return response()->json($request->user());
        });
        Route::post('progress', [ProgressController::class, 'store']);
    });
});