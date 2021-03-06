<?php

use App\Http\Controllers\RepositoriesController;
use Illuminate\Support\Facades\Route;

Route::get('/v1/repositories', [RepositoriesController::class, 'getDirectly'])->name('repository.getDirectly')->middleware('throttle:3,10');
Route::get('/v2/repositories', [RepositoriesController::class, 'index'])->name('repository.getFromSystem')->middleware('throttle:3,10');
