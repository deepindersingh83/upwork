<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\DescController;
use App\Http\Controllers\DimensionsController;
use App\Http\Controllers\NameController;
use App\Http\Controllers\RefController;
use App\Http\Controllers\AlloyController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('import/alloy', [AlloyController::class, 'import'])->name('import.alloy');
Route::post('import/ref', [RefController::class, 'import'])->name('import.ref');
Route::post('/name/import', [NameController::class, 'import']);
Route::post('/dimensions/import', [DimensionsController::class, 'import']);
Route::post('/brands/import', [BrandController::class, 'import']);
Route::post('/import-desc', [DescController::class, 'import']);
Route::post('/categories/import', [CategoryController::class, 'import']);
