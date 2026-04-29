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
use App\Livewire\Projects\Index as ProjectIndex;
use App\Livewire\Projects\Create as ProjectCreate;
use App\Livewire\Projects\Edit as ProjectEdit;
use App\Livewire\User\Create as UserCreate;
use App\Livewire\User\Edit as UserEdit;
use App\Livewire\User\Index as UserIndex;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (Auth::check()) {
        return Auth::user()->type === \App\UserType::Client 
            ? redirect()->route('client.dashboard') 
            : redirect()->route('dashboard');
    }

    return redirect()->route('login');
});

Route::middleware(['auth'])->group(function () {
    
    // --- Agent Only Routes ---
    Route::middleware(['agent'])->group(function () {
        Route::get('/dashboard', Dashboard::class)->name('dashboard');
        
        Route::get('/projects', ProjectIndex::class)->name('projects');
        Route::get('/projects/create', ProjectCreate::class)->name('projects.create');
        Route::get('/projects/{id}/edit', ProjectEdit::class)->name('projects.edit');

        Route::get('/tasks', TaskBoard::class)->name('tasks');
        Route::get('/tasks/create/project/{projectId}', TaskCreate::class)->name('tasks.create');
        Route::get('/tasks/{task}/edit', \App\Livewire\Task\Edit::class)->name('tasks.edit');

        Route::get('/users', UserIndex::class)->name('users');
        Route::get('/users/create', UserCreate::class)->name('users.create');
        Route::get('/users/{id}/edit', UserEdit::class)->name('users.edit');
        
        Route::get('/clients', \App\Livewire\Client\Index::class)->name('clients');
        Route::get('/clients/create', \App\Livewire\Client\Create::class)->name('clients.create');
        Route::get('/clients/{id}/edit', \App\Livewire\Client\Edit::class)->name('clients.edit');
        
        Route::get('/task-types', TaskTypeIndex::class)->name('task-types');
        Route::get('/task-statuses', TaskStatusIndex::class)->name('task-statuses');
        Route::get('/task-statuses/create', TaskStatusCreate::class)->name('task-statuses.create');
        Route::get('/task-statuses/{id}/edit', TaskStatusEdit::class)->name('task-statuses.edit');
        
        Route::get('/stages/create', StageCreate::class)->name('stages.create');
        Route::get('/stages/{id}/edit', StageEdit::class)->name('stages.edit');
        Route::get('/workflows', \App\Livewire\Workflow\Index::class)->name('workflows');
    });

    // --- Client Only Routes ---
    Route::middleware(['client'])->group(function () {
        Route::get('/client/dashboard', \App\Livewire\Client\Dashboard::class)->name('client.dashboard');
        Route::get('/client/projects', \App\Livewire\Client\Projects\Index::class)->name('client.projects');
        Route::get('/client/tasks', \App\Livewire\Client\Tasks\Board::class)->name('client.tasks');
    });

    Route::post('/logout', function () {
        Auth::logout();
        return redirect()->route('login');
    })->name('logout');
});

Route::get('/login', Login::class)->name('login')->middleware('guest');
