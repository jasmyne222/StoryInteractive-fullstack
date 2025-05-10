<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\StoryController;
use App\Http\Controllers\Api\ChapterController;


Route::get('/stories', [StoryController::class, 'index']);
Route::get('/chapters/{id}', [ChapterController::class, 'show']);




// Route::prefix('api/v1/')->group(function () {
//   Route::get('/test', function () {
//     return response()->json(['message' => 'Hello, World from api!']);
//   });

//   Route::delete('/test', function () {
//     return response()->json(['message' => 'Deleting']);
//   });

//   Route::post('/time', function () {
//     $timeClient = request()->input('timeClient', 0);
//     sleep(2); // Simulate a long-running process
//     return response()->json(['timeClient' => $timeClient, 'timeServer' => now()]);
//   });
// });