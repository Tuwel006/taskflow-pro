<?php

use App\Livewire\Auth\Login;
use App\Livewire\Dashboard;
use App\Livewire\Stages\Create as StageCreate;
use App\Livewire\Stages\Edit as StageEdit;
use App\Livewire\Stages\Index as StageIndex;
use App\Livewire\Task\Board as TaskBoard;
use App\Livewire\Task\Create as TaskCreate;
use App\Livewire\Task\Index as TaskIndex;
use App\Livewire\TaskStatus\Create as TaskStatusCreate;
use App\Livewire\TaskStatus\Edit as TaskStatusEdit;
use App\Livewire\TaskStatus\Index as TaskStatusIndex;
use App\Livewire\TaskTypes\Index as TaskTypeIndex;
use App\Livewire\Teams\Index as TeamIndex;
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
    Route::get('/tasks', TaskBoard::class)->name('tasks');
    Route::get('/users', UserIndex::class)->name('users');
    Route::get('/users/create', UserCreate::class)->name('users.create');
    Route::get('/users/{id}/edit', UserEdit::class)->name('users.edit');
    Route::post('/logout', function () {
        Auth::logout();

        return redirect()->route('login');
    })->name('logout');
    Route::get('/tasks/create/team/{teamId}', TaskCreate::class)->name('tasks.create');
    Route::get('/task-types', TaskTypeIndex::class)->name('task-types');
    Route::get('/teams', TeamIndex::class)->name('teams');
    Route::get('/task-statuses', TaskStatusIndex::class)->name('task-statuses');
    Route::get('/task-statuses/create', TaskStatusCreate::class)->name('task-statuses.create');
    Route::get('/task-statuses/{id}/edit', TaskStatusEdit::class)->name('task-statuses.edit');
    Route::get('/stages', StageIndex::class)->name('stages');
    Route::get('/stages/create', StageCreate::class)->name('stages.create');
    Route::get('/stages/{id}/edit', StageEdit::class)->name('stages.edit');
});

// Route::middleware(['guest'])->group(function () {
Route::get('/login', Login::class)->name('login')->middleware('guest');
// });
