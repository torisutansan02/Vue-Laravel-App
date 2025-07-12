<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('tasks'); // or your Vue root view
});

// Allow frontend routing while protecting /api/*
Route::get('/{any}', function () {
    return view('tasks');
})->where('any', '^(?!api).*$');
