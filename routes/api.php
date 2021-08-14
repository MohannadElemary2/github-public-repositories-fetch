<?php

use App\Http\Controllers\RepositoriesController;
use Illuminate\Support\Facades\Route;

Route::get('/v1/repositories', [RepositoriesController::class, 'getDirectly']);
Route::get('/v2/repositories', [RepositoriesController::class, 'index']);
