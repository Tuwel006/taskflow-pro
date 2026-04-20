<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Task\Index as TaskIndex;
use App\Livewire\User\Index as UserIndex;
use App\Livewire\User\Create as UserCreate;
use App\Livewire\User\Edit as UserEdit;
use Illuminate\Support\Facades\Auth;
use App\Livewire\Task\Create as TaskCreate;
use Illuminate\Http\Request;

Route::get('/', function () {
    if(Auth::check()){
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('livewire.dashboard');
    })->name('dashboard');
    Route::get('/tasks', TaskIndex::class)->name('tasks');
    Route::get('/users', UserIndex::class)->name('users');
    // Route::get('/users', function(Request $request){
    //     dd($request->userAgent());
    // })->name('users');
    Route::get('/users/create', UserCreate::class)->name('users.create');
    Route::get('/users/{id}/edit', UserEdit::class)->name('users.edit');
    Route::post('/logout', function () {
        Auth::logout();
        return redirect()->route('login');
    })->name('logout');
    Route::get('/tasks/create', TaskCreate::class)->name('tasks.create');
    Route::get('/my-tasks', App\Livewire\MyTasks\Index::class)->name('my-tasks');
});

Route::middleware(['guest'])->group(function () {
    Route::get('/login', App\Livewire\Auth\Login::class)->name('login');
});
