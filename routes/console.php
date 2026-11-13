<?php

use Illuminate\Support\Facades\Artisan;

Artisan::command('ell:about', function (): void {
    $this->info('English Literacy Lab — ISL-first literacy platform');
})->purpose('Display the ELL project identity');
