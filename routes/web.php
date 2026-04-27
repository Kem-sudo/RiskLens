<?php

use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\RiskController;
use App\Http\Controllers\ComplianceController;
use App\Http\Controllers\IncidentController;
use App\Http\Controllers\PolicyController;
use App\Http\Controllers\AuditController;
use App\Http\Controllers\ForgotPasswordController;
use Illuminate\Support\Facades\Route;

// Landing Page
Route::get('/', [LandingPageController::class, 'index'])->name('landing');

// Login Routes
Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/forgot-password', [ForgotPasswordController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLink'])->name('password.email');
Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset.form');
Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword'])->name('password.update');

// Registration Routes
Route::get('/register', [RegisterController::class, 'showRegister'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Dashboard
Route::get('/dashboard', [LoginController::class, 'dashboard'])
    ->middleware(['permission:dashboard.view'])
    ->name('dashboard');

// Risk Management Routes
Route::prefix('risks')->group(function () {
    Route::get('/', [RiskController::class, 'index'])->middleware(['permission:risks.view'])->name('risks.index');
    Route::get('/create', [RiskController::class, 'create'])->middleware(['permission:risks.create'])->name('risks.create');
    Route::post('/', [RiskController::class, 'store'])->middleware(['permission:risks.create'])->name('risks.store');
    Route::get('/{id}/edit', [RiskController::class, 'edit'])->middleware(['permission:risks.update'])->name('risks.edit');
    Route::put('/{id}', [RiskController::class, 'update'])->middleware(['permission:risks.update'])->name('risks.update');
    Route::delete('/{id}', [RiskController::class, 'destroy'])->middleware(['permission:risks.delete'])->name('risks.destroy');
});

// Compliance Monitoring Routes
Route::prefix('compliance')->group(function () {
    Route::get('/', [ComplianceController::class, 'index'])->middleware(['permission:compliance.view'])->name('compliance.index');
    Route::get('/create', [ComplianceController::class, 'create'])->middleware(['permission:compliance.create'])->name('compliance.create');
    Route::post('/', [ComplianceController::class, 'store'])->middleware(['permission:compliance.create'])->name('compliance.store');
    Route::get('/{id}/edit', [ComplianceController::class, 'edit'])->middleware(['permission:compliance.update'])->name('compliance.edit');
    Route::put('/{id}', [ComplianceController::class, 'update'])->middleware(['permission:compliance.update'])->name('compliance.update');
    Route::delete('/{id}', [ComplianceController::class, 'destroy'])->middleware(['permission:compliance.delete'])->name('compliance.destroy');
});

// Incident Tracking Routes
Route::prefix('incidents')->group(function () {
    Route::get('/', [IncidentController::class, 'index'])->middleware(['permission:incidents.view'])->name('incidents.index');
    Route::get('/create', [IncidentController::class, 'create'])->middleware(['permission:incidents.create'])->name('incidents.create');
    Route::post('/', [IncidentController::class, 'store'])->middleware(['permission:incidents.create'])->name('incidents.store');
    Route::get('/{id}/edit', [IncidentController::class, 'edit'])->middleware(['permission:incidents.update'])->name('incidents.edit');
    Route::put('/{id}', [IncidentController::class, 'update'])->middleware(['permission:incidents.update'])->name('incidents.update');
    Route::delete('/{id}', [IncidentController::class, 'destroy'])->middleware(['permission:incidents.delete'])->name('incidents.destroy');
    Route::delete('/attachments/{id}', [IncidentController::class, 'deleteAttachment'])->middleware(['permission:incidents.update'])->name('incidents.attachments.destroy');
});

// Policy Management Routes
Route::prefix('policies')->group(function () {
    Route::get('/', [PolicyController::class, 'index'])->middleware(['permission:policies.view'])->name('policies.index');
    Route::get('/create', [PolicyController::class, 'create'])->middleware(['permission:policies.create'])->name('policies.create');
    Route::post('/', [PolicyController::class, 'store'])->middleware(['permission:policies.create'])->name('policies.store');
    Route::get('/{id}/edit', [PolicyController::class, 'edit'])->middleware(['permission:policies.update'])->name('policies.edit');
    Route::put('/{id}', [PolicyController::class, 'update'])->middleware(['permission:policies.update'])->name('policies.update');
    Route::delete('/{id}', [PolicyController::class, 'destroy'])->middleware(['permission:policies.delete'])->name('policies.destroy');
    Route::post('/{id}/acknowledge', [PolicyController::class, 'acknowledge'])->middleware(['permission:policies.acknowledge'])->name('policies.acknowledge');
    Route::get('/{id}/acknowledgments', [PolicyController::class, 'usersForAcknowledgment'])->middleware(['permission:policies.acknowledgments.view'])->name('policies.acknowledgments');
});

// Internal Audit Routes
Route::prefix('audits')->group(function () {
    Route::get('/', [AuditController::class, 'index'])->middleware(['permission:audits.view'])->name('audits.index');
    Route::get('/create', [AuditController::class, 'create'])->middleware(['permission:audits.create'])->name('audits.create');
    Route::post('/', [AuditController::class, 'store'])->middleware(['permission:audits.create'])->name('audits.store');
    Route::get('/{id}/edit', [AuditController::class, 'edit'])->middleware(['permission:audits.update'])->name('audits.edit');
    Route::put('/{id}', [AuditController::class, 'update'])->middleware(['permission:audits.update'])->name('audits.update');
    Route::delete('/{id}', [AuditController::class, 'destroy'])->middleware(['permission:audits.delete'])->name('audits.destroy');
    Route::get('/{id}/report', [AuditController::class, 'report'])->middleware(['permission:audits.report'])->name('audits.report');
});
