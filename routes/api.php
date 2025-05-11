<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\StoryController;
use App\Http\Controllers\Api\ChapterController;
use App\Http\Controllers\Api\ChoiceController;
use App\Http\Controllers\Api\ProgressController;
use Illuminate\Http\Request;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/stories', [StoryController::class, 'index']);
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::get('/chapters/{id}', [ChapterController::class, 'show']);
    Route::get('/stories/{id}/first-chapter', [ChapterController::class, 'firstChapter']);
    Route::post('/choices', [ChoiceController::class, 'store']);
    Route::get('/progress', [ProgressController::class, 'show']);
    Route::post('/progress', [ProgressController::class, 'store']);
});