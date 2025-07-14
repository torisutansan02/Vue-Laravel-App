<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

Route::get('/tasks', [TaskController::class, 'read']);
Route::get('/tasks/{id}', [TaskController::class, 'readOne']);
Route::post('/tasks', [TaskController::class, 'create']);
Route::put('/tasks/{id}', [TaskController::class, 'update']);
Route::delete('/tasks/{id}', [TaskController::class, 'delete']);

?>