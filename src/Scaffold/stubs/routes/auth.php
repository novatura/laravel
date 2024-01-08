<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\TwoFactorController;
use App\Http\Controllers\Auth\NewEmailController;
use App\Http\Controllers\Auth\RequestVerificationController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])->name("register");
    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name("login");
    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('two-factor/verify', [TwoFactorController::class, 'verify'])->name('two-factor.verify');
    Route::get('two-factor/recover', [TwoFactorController::class, 'recover'])->name('two-factor.recover');
    Route::post('two-factor/verify', [TwoFactorController::class, 'verify_store'])->name('two-factor.verify_store');
    Route::post('two-factor/recover', [TwoFactorController::class, 'recover_store'])->name('two-factor.recover_store');
    
    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
    ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store');

});

Route::middleware('auth')->group(function () {

    Route::get('verify-email', [RequestVerificationController::class, 'create'])
        ->name('verify.email');

    Route::post('verify-email', [RequestVerificationController::class, 'store'])
        ->name('verify.email.send');

    Route::get('verify-email/code', [VerifyEmailController::class, 'index'])
        ->name('verify.email.code');

    Route::post('verify-email/code', [VerifyEmailController::class, 'verify'])
        ->name('verify.email.verify');

    Route::get('verify-email/email', [NewEmailController::class, 'edit'])
        ->name('verify.email.edit');

    Route::put('verify-email/email', [NewEmailController::class, 'update'])
        ->name('verify.email.update');

    Route::put('email', [NewEmailController::class, 'updateAndConfirm'])
        ->name('email.update');

    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])->name('password.confirm');
    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store'])->name('password.confirm.store');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});

Route::middleware(['auth', 'password.confirm'])->group(function () {
    Route::get('two-factor/create', [TwoFactorController::class, 'setup'])->name('two-factor.create');
    Route::post('two-factor/store', [TwoFactorController::class, 'store'])->name('two-factor.store');
    Route::delete('two-factor/destroy', [TwoFactorController::class, 'destroy'])->name('two-factor.destroy');
    Route::get('two-factor/recovery-codes', [TwoFactorController::class, 'recovery_codes'])->name('two-factor.recovery_codes');
    Route::get('two-factor/recovery-codes/download', [TwoFactorController::class, 'download_recovery_codes'])->name('two-factor.recovery_codes.download');
});
