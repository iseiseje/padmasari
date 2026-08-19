<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StoryGeneratorController;
use App\Http\Controllers\LearningModuleController;
use App\Http\Controllers\AdminController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Story Generator Routes
Route::get('/story-generator', [StoryGeneratorController::class, 'index'])->name('story-generator.index');
Route::post('/story-generator/generate', [StoryGeneratorController::class, 'generate'])->name('story-generator.generate');
Route::get('/story-generator/{story}', [StoryGeneratorController::class, 'show'])->name('story-generator.show');

// Learning Module Routes
Route::get('/modules', [LearningModuleController::class, 'index'])->name('modules.index');
Route::get('/modules/{module}', [LearningModuleController::class, 'show'])->name('modules.show');

// Admin Routes (Admin Only Mode)
Route::get('/admin/login', [AdminController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'login'])->name('admin.login.submit');
Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
Route::put('/admin/master-narrative', [AdminController::class, 'updateMasterNarrative'])->name('admin.master-narrative.update');
Route::post('/admin/stories', [AdminController::class, 'storeStory'])->name('admin.stories.store');

Route::get('/admin/stories/{story}/edit', [AdminController::class, 'editStory'])->name('admin.stories.edit');
Route::put('/admin/stories/{story}', [AdminController::class, 'updateStory'])->name('admin.stories.update');
Route::delete('/admin/stories/{story}', [AdminController::class, 'destroyStory'])->name('admin.stories.destroy');

Route::post('/admin/modules', [AdminController::class, 'storeModule'])->name('admin.modules.store');
Route::get('/admin/modules/{module}/edit', [AdminController::class, 'editModule'])->name('admin.modules.edit');
Route::put('/admin/modules/{module}', [AdminController::class, 'updateModule'])->name('admin.modules.update');
Route::delete('/admin/modules/{module}', [AdminController::class, 'destroyModule'])->name('admin.modules.destroy');

Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');
