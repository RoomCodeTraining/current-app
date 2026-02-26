<?php

use App\Http\Controllers\CardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ModifierController;
use Illuminate\Support\Facades\Route;

// Accueil
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
Route::post('/', [HomeController::class, 'store']);

// Page détail carte (lien public court /c/AB3X9K)
Route::get('/c/{shortCode}', [CardController::class, 'show'])->name('card.show');

// Modifier ma carte : identifiant (short_code) + code
Route::get('/modifier', [ModifierController::class, 'index'])->name('modifier.index');
Route::get('/modifier/switch/{shortCode}', [ModifierController::class, 'switchCard'])->name('modifier.switch');
Route::post('/modifier', [ModifierController::class, 'login'])->name('modifier.login');
Route::post('/modifier/logout', [ModifierController::class, 'logout'])->name('modifier.logout');
Route::put('/modifier', [ModifierController::class, 'update'])->name('modifier.update');

// QR et vCard
Route::get('/card/{shortCode}/qr', [HomeController::class, 'qr'])->name('card.qr');
Route::get('/card/{shortCode}/vcard', [HomeController::class, 'vcard'])->name('card.vcard');
