<?php

use Illuminate\Support\Facades\Route;

// Public Routes
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\JournalController;
use App\Http\Controllers\Public\ArticleController;
use App\Http\Controllers\Public\SearchController;

// Author Routes
use App\Http\Controllers\Author\DashboardController as AuthorDashboard;
use App\Http\Controllers\Author\ManuscriptController;
use App\Http\Controllers\Author\ProfileController;

// Editor Routes
use App\Http\Controllers\Editor\DashboardController as EditorDashboard;
use App\Http\Controllers\Editor\ReviewController;
use App\Http\Controllers\Editor\MessageController as EditorMessageController;

// Admin Routes
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\JournalController as AdminJournalController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\ArticleController as AdminArticleController;

// ─────────────────────────────────────────
// PUBLIC ROUTES
// ─────────────────────────────────────────
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/journals', [JournalController::class, 'index'])->name('journals.index');
Route::get('/journals/{slug}', [JournalController::class, 'show'])->name('journals.show');
Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');
Route::get('/articles/{slug}', [ArticleController::class, 'show'])->name('articles.show');
Route::get('/search', [SearchController::class, 'index'])->name('search');
Route::get('/about', function () { return view('public.about'); })->name('about');
Route::get('/contact', function () { return view('public.contact'); })->name('contact');

// ─────────────────────────────────────────
// AUTH ROUTES (Breeze)
// ─────────────────────────────────────────
require __DIR__.'/auth.php';

// ─────────────────────────────────────────
// AUTHOR ROUTES
// ─────────────────────────────────────────
Route::middleware(['auth', 'role:author'])
    ->prefix('author')
    ->name('author.')
    ->group(function () {
        Route::get('/dashboard', [AuthorDashboard::class, 'index'])->name('dashboard');

        // Manuscripts
        Route::get('/manuscripts', [ManuscriptController::class, 'index'])->name('manuscripts.index');
        Route::get('/manuscripts/create', [ManuscriptController::class, 'create'])->name('manuscripts.create');
        Route::post('/manuscripts', [ManuscriptController::class, 'store'])->name('manuscripts.store');
        Route::get('/manuscripts/{id}/edit', [ManuscriptController::class, 'edit'])->name('manuscripts.edit');
        Route::put('/manuscripts/{id}', [ManuscriptController::class, 'update'])->name('manuscripts.update');
        Route::delete('/manuscripts/{id}', [ManuscriptController::class, 'destroy'])->name('manuscripts.destroy');

        // Profile
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    });

// ─────────────────────────────────────────
// EDITOR ROUTES
// ─────────────────────────────────────────
Route::middleware(['auth', 'role:editor'])
    ->prefix('editor')
    ->name('editor.')
    ->group(function () {
        Route::get('/dashboard', [EditorDashboard::class, 'index'])->name('dashboard');

        // Manuscript review
        Route::get('/manuscripts', [ReviewController::class, 'index'])->name('manuscripts.index');
        Route::get('/manuscripts/{id}', [ReviewController::class, 'show'])->name('manuscripts.show');
        Route::post('/manuscripts/{id}/approve', [ReviewController::class, 'approve'])->name('manuscripts.approve');
        Route::post('/manuscripts/{id}/reject', [ReviewController::class, 'reject'])->name('manuscripts.reject');

        // Article management
        Route::get('/articles', [ReviewController::class, 'articles'])->name('articles.index');
        Route::post('/articles/{id}/unpublish', [ReviewController::class, 'unpublish'])->name('articles.unpublish');
        Route::delete('/articles/{id}', [ReviewController::class, 'deleteArticle'])->name('articles.delete');

        // Messages
        Route::get('/messages', [EditorMessageController::class, 'index'])->name('messages.index');
        Route::post('/messages', [EditorMessageController::class, 'store'])->name('messages.store');
    });

// ─────────────────────────────────────────
// SUPER ADMIN ROUTES
// ─────────────────────────────────────────
Route::middleware(['auth', 'role:super_admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');

        // Users
        Route::resource('/users', UserController::class);

        // Journals
        Route::resource('/journals', AdminJournalController::class);

        // Articles
        Route::get('/articles', [AdminArticleController::class, 'index'])->name('articles.index');
        Route::post('/articles/{id}/unpublish', [AdminArticleController::class, 'unpublish'])->name('articles.unpublish');
        Route::delete('/articles/{id}', [AdminArticleController::class, 'deleteArticle'])->name('articles.delete');
        Route::post('/articles/{id}/message', [AdminArticleController::class, 'sendMessage'])->name('articles.message');

        // Settings
        Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
        Route::post('/settings', [SettingsController::class, 'update'])->name('settings.update');
    });