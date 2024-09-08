<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/user-preference', [ProfileController::class, 'showPreference'])->name('user-preference');
    Route::patch('/update-user-preference', [ProfileController::class, 'updatePreference'])->name('user-preference.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/generate-recipe', [ProfileController::class, 'generateRecipe'])->name('generate-recipe');
});

require __DIR__.'/auth.php';
