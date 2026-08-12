<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminJobController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\AIController;

// 1️الرئيسية وتفاصيل الوظائف
Route::get('/', [JobController::class, 'index'])->name('jobs.index');
Route::get('/jobs/{id}', [JobController::class, 'show'])->name('jobs.show');

// 2️ مسار الـ Dashboard (تحويل للرئيسية)
Route::get('/dashboard', function () {
    return redirect()->route('jobs.index');
})->middleware(['auth'])->name('dashboard');

// 3️ مسارات الذكاء الاصطناعي (AI Chatbot & Recommendations)
Route::post('/ai/chat', [AIController::class, 'chat'])->name('ai.chat');
Route::post('/ai/recommend/{jobId}', [AIController::class, 'recommend'])->name('ai.recommend');

// 4️ مسارات المستخدمين المسجلين (Applicants)
Route::middleware('auth')->group(function () {
    Route::post('/jobs/{id}/apply', [JobController::class, 'apply'])->name('jobs.apply');
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// 5️مسارات لوحة التحكم (Admin Panel)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/jobs', [AdminJobController::class, 'index'])->name('jobs.index');
    Route::get('/jobs/create', [AdminJobController::class, 'create'])->name('jobs.create');
    Route::post('/jobs', [AdminJobController::class, 'store'])->name('jobs.store');
    Route::get('/jobs/{id}/edit', [AdminJobController::class, 'edit'])->name('jobs.edit');
    Route::put('/jobs/{id}', [AdminJobController::class, 'update'])->name('jobs.update');
    Route::delete('/jobs/{id}', [AdminJobController::class, 'destroy'])->name('jobs.destroy');

    Route::get('/applications', [AdminJobController::class, 'applications'])->name('applications.index');
});

// 6️ مسارات المصادقة (Authentication Routes)
require __DIR__.'/auth.php';
Route::delete('/jobs/{id}/cancel', [JobController::class, 'cancelApply'])->name('jobs.cancel');