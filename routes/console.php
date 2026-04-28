<?php

use App\Jobs\CheckUserTasks;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Schedule::job(new CheckUserTasks)->dailyAt('11:30')->withoutOverlapping();

Schedule::call(function () {
    Log::info('CheckUserTasks job started at ' . now());
})->everyMinute();
