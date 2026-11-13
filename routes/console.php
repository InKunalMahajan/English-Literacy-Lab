<?php

use Illuminate\Support\Facades\Artisan;

Artisan::command('ell:about', function (): void {
    $this->info('English Literacy Lab — ISL-first literacy platform');
})->purpose('Display the ELL project identity');

Artisan::command('ell:grant-editor {email}', function (string $email): void {
    $user = \App\Models\User::query()->where('email', $email)->first();
    if (! $user || ! $user->is_active) {
        $this->error('Active user not found. No changes made.');
        return;
    }
    if (! $this->confirm("Grant curriculum editor access to {$user->email}?", false)) {
        $this->warn('Cancelled.');
        return;
    }
    $user->forceFill(['is_content_editor' => true])->save();
    $this->info('Editor access granted.');
})->purpose('Explicitly grant curriculum editing permission to an existing active user');

Artisan::command('ell:revoke-editor {email}', function (string $email): void {
    $user = \App\Models\User::query()->where('email', $email)->first();
    if (! $user) {
        $this->error('User not found.');
        return;
    }
    if (! $this->confirm("Revoke curriculum editor access from {$user->email}?", false)) {
        $this->warn('Cancelled.');
        return;
    }
    $user->forceFill(['is_content_editor' => false])->save();
    $this->info('Editor access revoked.');
})->purpose('Revoke curriculum editing permission');
