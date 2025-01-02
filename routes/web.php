<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Livewire\Admin\Category\CategoryIndex;
use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\Product\ProductIndex;
use App\Livewire\Admin\Product\ProductUpdate;

Auth::routes();

// Route umum (tanpa autentikasi)
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Route dengan autentikasi
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard.index');
    Route::get('/categories', CategoryIndex::class)->name('categories.index');
    Route::get('/products', ProductIndex::class)->name('products.index');
    Route::get('/products/{id}/edit', ProductUpdate::class)->name('products.update');
});

