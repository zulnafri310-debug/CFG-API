<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DialogueController;
use App\Http\Controllers\GrammarTemplateController;
use App\Http\Controllers\WordController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('word', WordController::class);
Route::apiResource('category', CategoryController::class);
Route::apiResource('grammar-template', GrammarTemplateController::class);

Route::get('/dialogue/generate', DialogueController::class);