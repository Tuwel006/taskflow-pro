<?php

use App\Livewire\Auth\Login;
use App\Livewire\Channels\Index as ChannelIndex;
use App\Livewire\Dashboard;
use App\Livewire\MyTasks\Index;
use App\Livewire\Task\Create as TaskCreate;
use App\Livewire\Task\Index as TaskIndex;
use App\Livewire\TaskTypes\Index as TaskTypeIndex;
use App\Livewire\User\Create as UserCreate;
use App\Livewire\User\Edit as UserEdit;
use App\Livewire\User\Index as UserIndex;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }

    return redirect()->route('login');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/tasks', TaskIndex::class)->name('tasks');
    Route::get('/users', UserIndex::class)->name('users');
    Route::get('/users/create', UserCreate::class)->name('users.create');
    Route::get('/users/{id}/edit', UserEdit::class)->name('users.edit');
    Route::post('/logout', function () {
        Auth::logout();

        return redirect()->route('login');
    })->name('logout');
    Route::get('/tasks/create', TaskCreate::class)->name('tasks.create');
    Route::get('/my-tasks', Index::class)->name('my-tasks');
    Route::get('/teams', ChannelIndex::class)->name('teams');
    Route::get('/task-types', TaskTypeIndex::class)->name('task-types');
});

// Route::middleware(['guest'])->group(function () {
Route::get('/login', Login::class)->name('login')->middleware('guest')->middleware('throttle:2,1');
// });
