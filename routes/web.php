<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::get('/', [ProductController::class, 'index']);

// Resource route otomatis mendaftarkan semua method CRUD (index, create, store, show, edit, update, destroy)
Route::resource('products', ProductController::class);