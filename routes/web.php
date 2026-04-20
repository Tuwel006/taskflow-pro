<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('livewire.dashboard.index');
})->name('dashboard');

Route::get('/tasks', function () {
    return view('livewire.task.index');
})->name('tasks');
