<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\BorrowRequestController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/community', function () {
    return view('community');
})->middleware(['auth', 'verified'])->name('community');

Route::middleware('auth')->group(function () {
    Route::get('/closet', [ListingController::class, 'index'])->name('closet');
    Route::post('/closet', [ListingController::class, 'store']);
    Route::delete('/closet/{listingId}', [ListingController::class, 'destroy']);

    Route::get('/borrow', [BorrowRequestController::class, 'requests'])->name('borrow');
    Route::post('/borrow/{requestId}', [BorrowRequestController::class, 'store']);
    Route::delete('borrow/{requestId}', [BorrowRequestController::class, 'destroy']);

    Route::get('/lend', [ListingController::class, 'manage'])->name('lend');
    Route::patch('/lend/{listingId}', [ListingController::class, 'update']);
    Route::delete('/lend/{listingId}', [ListingController::class, 'destroy']);
    Route::patch('/lend/{listingId}/approve', [BorrowRequestController::class, 'approve']);
    Route::patch('/lend/{listingId}/reject', [BorrowRequestController::class, 'reject']);
    Route::patch('lend/{listingId}/return', [BorrowRequestController::class, 'return']);

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
