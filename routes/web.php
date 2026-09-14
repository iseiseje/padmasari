<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\AdminController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Static Document Reader Routes (from resources/dokumen/)
Route::get('/novel', [DocumentController::class, 'novel'])->name('documents.novel');
Route::get('/naskah-cerita', [DocumentController::class, 'naskah'])->name('documents.naskah');
Route::get('/drama', [DocumentController::class, 'drama'])->name('documents.drama');

// Admin Routes
Route::get('/admin/login', [AdminController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'login'])->name('admin.login.submit');
Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
Route::put('/admin/master-narrative', [AdminController::class, 'updateMasterNarrative'])->name('admin.master-narrative.update');
Route::post('/admin/stories', [AdminController::class, 'storeStory'])->name('admin.stories.store');

Route::get('/admin/stories/{story}/edit', [AdminController::class, 'editStory'])->name('admin.stories.edit');
Route::put('/admin/stories/{story}', [AdminController::class, 'updateStory'])->name('admin.stories.update');
Route::delete('/admin/stories/{story}', [AdminController::class, 'destroyStory'])->name('admin.stories.destroy');

Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');
