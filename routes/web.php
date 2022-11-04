<?php

use App\Http\Controllers\ExtractController;
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

Route::get('/mix_infos/{mix_info}/create', [MixInfoController::class, 'createBorn'])
    ->name('born_infos.create'); //createという名のedit
Route::patch('/mix_infos/{mix_info}/store', [MixInfoController::class, 'storeBorn'])
    ->name('born_infos.store'); //storeという名のpatch
Route::get('/mix_infos/{mix_info}/edit', [MixInfoController::class, 'editBorn'])
    ->name('born_infos.edit');
Route::patch('/mix_infos/{mix_info}/update', [MixInfoController::class, 'updateBorn'])
    ->name('born_infos.update');
Route::patch('/mix_infos/{mix_info}/delete', [MixInfoController::class, 'destroyBorn'])
    ->name('born_infos.destroy'); //deleteという名のpatch

Route::get('/extracts', [ExtractController::class, 'index'])
    ->name('extracts.index');

Route::post('/female_pigs/export', [FemalePigController::class, 'export'])
    ->name('female_pigs.export');
Route::post('/female_pigs/import', [FemalePigController::class, 'import'])
    ->name('female_pigs.import');

