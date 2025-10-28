<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PeiceController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('front.home');
// });

Route::name('front.')->group(function () {
    Route::get('/', [HomeController::class, 'home'])->name('home');
    Route::get('/pieces', [PeiceController::class, 'index'])->name('list');
});


