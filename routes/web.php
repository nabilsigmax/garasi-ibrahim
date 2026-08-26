<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\ChatController;

// Public Routes
Route::get('/', [CarController::class, 'index'])->name('landing');
Route::get('/home', function () {
    return redirect()->route('landing');
})->name('home');
Route::get('/car/{id}', [CarController::class, 'show'])->name('cars.show');

// Auth Routes (Login, Register, Admin Login)
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.store');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.store');
Route::get('/admin/login', [AuthController::class, 'showAdminLoginForm'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'adminLogin'])->name('admin.login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Authenticated Routes (Perlu Login)
Route::middleware(['auth'])->group(function () {
    // Wishlist Routes
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/toggle/{carId}', [WishlistController::class, 'toggle'])->name('wishlist.toggle');

    // Chat System Routes
    Route::post('/chat/room', [ChatController::class, 'getOrCreateRoom'])->name('chat.room');
    Route::get('/chat/admin/rooms', [ChatController::class, 'getAdminRooms'])->name('chat.admin.rooms');
    Route::get('/chat/{roomId}/messages', [ChatController::class, 'getMessages'])->name('chat.messages');
    Route::post('/chat/send', [ChatController::class, 'sendMessage'])->name('chat.send');
    Route::post('/chat/message', [ChatController::class, 'sendMessage']);
    Route::delete('/chat/room/{id}', [ChatController::class, 'deleteRoom'])->name('chat.room.delete');

    // Admin Routes (Cars Management & Inbox)
    Route::get('/admin', [CarController::class, 'adminIndex'])->name('admin.index');
    Route::post('/admin/cars', [CarController::class, 'store'])->name('cars.store');
    Route::put('/admin/cars/{car}', [CarController::class, 'update'])->name('cars.update');
    Route::delete('/admin/cars/{car}', [CarController::class, 'destroy'])->name('cars.destroy');
    Route::get('/admin/consultation', [ChatController::class, 'adminInbox'])->name('admin.consultation');
});