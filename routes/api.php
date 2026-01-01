<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LikeController;

Route::middleware('auth:sanctum')->post(
    '/posts/{post}/like',
    [LikeController::class, 'toggle']
);

