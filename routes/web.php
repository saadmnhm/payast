<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('front.home');
// });

Route::name('front.')->group(function () {
    Route::get('/', [HomeController::class, 'home'])->name('home');
});


