<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
  return view('test');
});


// require __DIR__.'/auth.php';