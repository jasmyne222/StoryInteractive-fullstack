<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\StoryController;
use App\Http\Controllers\Api\ChapterController;
use App\Http\Controllers\Api\ChoiceController;
use App\Http\Controllers\Api\ProgressController;
use Illuminate\Http\Request;

// Routes publiques (enlever auth:sanctum pour test)
Route::get('/stories', [StoryController::class, 'index']);
Route::get('/stories/{id}/first-chapter', [ChapterController::class, 'firstChapter']);
Route::get('/chapters/{id}', [ChapterController::class, 'show']);
Route::get('/choices/{chapterId}', [ChoiceController::class, 'index']);

// Routes protégées
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('/choices', [ChoiceController::class, 'store']);
    Route::get('/progress', [ProgressController::class, 'show']);
    Route::post('/progress', [ProgressController::class, 'store']);
});