<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\CurriculumController;
use App\Http\Controllers\LessonAuthoringController;
use App\Http\Controllers\LessonActivityController;
use App\Http\Controllers\LessonCompletionController;
use App\Http\Controllers\LearnerDashboardController;
use App\Http\Controllers\ActivityAuthoringController;
use App\Http\Controllers\LessonMediaController;
use App\Http\Controllers\WritingPracticeController;
use App\Http\Controllers\LessonAssessmentController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');
Route::get('/curriculum', [CurriculumController::class, 'index'])->name('curriculum.index');
Route::post('/activities/{activity}/check', [LessonActivityController::class, 'check'])->middleware('throttle:20,1')->name('activities.check');
Route::get('/media/{media}', [LessonMediaController::class, 'show'])->name('media.show');
Route::get('/curriculum/{lesson}', [CurriculumController::class, 'show'])->name('curriculum.show');

Route::middleware('guest')->group(function (): void {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])->middleware('throttle:5,1')->name('login.store');
});

Route::middleware('auth')->group(function (): void {
    Route::get('/curriculum/{lesson}/assessment', [LessonAssessmentController::class, 'show'])->name('assessments.show');
    Route::post('/curriculum/{lesson}/assessment', [LessonAssessmentController::class, 'submit'])->middleware('throttle:5,1')->name('assessments.submit');
    Route::get('/dashboard', [LearnerDashboardController::class, 'index'])->name('dashboard');
    Route::post('/curriculum/{lesson}/writing', [WritingPracticeController::class, 'store'])->middleware('throttle:10,1')->name('curriculum.writing.store');
    Route::post('/curriculum/{lesson}/complete', [LessonCompletionController::class, 'store'])->middleware('throttle:20,1')->name('curriculum.complete');
    Route::get('/authoring', [LessonAuthoringController::class, 'index'])->name('authoring.index');
    Route::post('/authoring/modules', [LessonAuthoringController::class, 'module'])->name('authoring.modules.store');
    Route::post('/authoring/units', [LessonAuthoringController::class, 'unit'])->name('authoring.units.store');
    Route::post('/authoring/lessons', [LessonAuthoringController::class, 'lesson'])->name('authoring.lessons.store');
    Route::get('/authoring/lessons/{lesson}/edit', [LessonAuthoringController::class, 'edit'])->name('authoring.lessons.edit');
    Route::put('/authoring/lessons/{lesson}', [LessonAuthoringController::class, 'update'])->name('authoring.lessons.update');
    Route::delete('/authoring/lessons/{lesson}', [LessonAuthoringController::class, 'destroy'])->name('authoring.lessons.destroy');
    Route::post('/authoring/lessons/{lesson}/publish', [LessonAuthoringController::class, 'publish'])->name('authoring.lessons.publish');
    Route::post('/authoring/lessons/{lesson}/activities', [LessonAuthoringController::class, 'activity'])->name('authoring.activities.store');
    Route::get('/authoring/activities/{activity}/edit', [ActivityAuthoringController::class, 'edit'])->name('authoring.activities.edit');
    Route::put('/authoring/activities/{activity}', [ActivityAuthoringController::class, 'update'])->name('authoring.activities.update');
    Route::delete('/authoring/activities/{activity}', [ActivityAuthoringController::class, 'destroy'])->name('authoring.activities.destroy');
    Route::post('/authoring/lessons/{lesson}/media', [LessonMediaController::class, 'store'])->name('authoring.media.store');
    Route::delete('/authoring/media/{media}', [LessonMediaController::class, 'destroy'])->name('authoring.media.destroy');
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});
