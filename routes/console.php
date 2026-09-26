<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Sauvegarde quotidienne (base de données + fichiers médias) via spatie/laravel-backup.
// Nécessite que le cron système appelle `php artisan schedule:run` chaque minute
// (voir README : configuration après mise en ligne).
Schedule::command('backup:clean')->daily()->at('01:00');
Schedule::command('backup:run')->daily()->at('01:30');
