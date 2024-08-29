<?php

use App\Models\Name;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return Name::query()
        ->with('category', 'description')
        ->whereNotNull('ls_name')
        ->limit(10)
        ->get()
        ->map(fn(Name $name) => [
            ['name' => $name->ls_name, 'description' => Str::limit($name->description?->ls_description, 100)],
            ['name' => $name->alloy_name, 'description' => Str::limit($name->description?->alloy_description, 100)],
        ])
        ->flatMap(fn ($item) => $item)
        ->all();
});
