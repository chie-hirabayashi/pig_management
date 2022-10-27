<?php

use App\Http\Controllers\BornInfoController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FemalePigController;
use App\Http\Controllers\MalePigController;
use App\Http\Controllers\MixInfoController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';


Route::resource('female_pigs', FemalePigController::class);
Route::resource('male_pigs', MalePigController::class);
Route::resource('female_pigs.mix_infos', MixInfoController::class);
Route::resource('mix_infos.born_infos', BornInfoController::class);
