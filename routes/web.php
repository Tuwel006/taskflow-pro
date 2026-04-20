<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Task\Index as TaskIndex;
use App\Livewire\User\Index as UserIndex;
use App\Livewire\User\Create as UserCreate;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('livewire.dashboard');
})->name('dashboard');

Route::get('/tasks', TaskIndex::class)->name('tasks');

Route::get('/users', UserIndex::class)->name('users');

Route::get('/users/create', UserCreate::class)->name('users.create');
