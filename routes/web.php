<?php

use App\Http\Controllers\ExtractController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FemalePigController;
use App\Http\Controllers\MalePigController;
use App\Http\Controllers\MixInfoController;
use App\Http\Controllers\ImportExportController;
use App\Http\Controllers\BornInfoController;

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
})
    ->middleware(['auth'])
    ->name('dashboard');

require __DIR__ . '/auth.php';

// 基本のルーティング
Route::resource('female_pigs', FemalePigController::class);
Route::resource('male_pigs', MalePigController::class);
Route::resource('female_pigs.mix_infos', MixInfoController::class);
// Route::resource('female_pigs.born_infos', BornInfoController::class);

// 出産情報に関するルーティング
Route::get('/mix_infos/{mix_info}/create', [
    MixInfoController::class,
    'createBorn',
])->name('born_infos.create'); //createという名のedit
Route::patch('/mix_infos/{mix_info}/store', [
    MixInfoController::class,
    'storeBorn',
])->name('born_infos.store'); //storeという名のpatch
Route::get('/mix_infos/{mix_info}/edit', [
    MixInfoController::class,
    'editBorn',
])->name('born_infos.edit');
Route::patch('/mix_infos/{mix_info}/update', [
    MixInfoController::class,
    'updateBorn',
])->name('born_infos.update');
Route::patch('/mix_infos/{mix_info}/delete', [
    MixInfoController::class,
    'destroyBorn',
])->name('born_infos.destroy'); //deleteという名のpatch

// 抽出のルーティング
Route::post('/extracts', [ExtractController::class, 'index'])->name(
    'extracts.index'
);
Route::get('/extracts/conditions', [
    ExtractController::class,
    'conditions',
])->name('extracts.conditions');

// インポートフォーム
Route::get('/imports_exports/form', [ImportExportController::class, 'form'])->name(
    'imports_exports.form'
);

// female_pigsのインポートとエクスポート
Route::post('/female_pigs/export', [
    FemalePigController::class,
    'export',
])->name('female_pigs.export');
Route::post('/female_pigs/import', [
    FemalePigController::class,
    'import',
])->name('female_pigs.import');

// male_pigsのインポートとエクスポート
Route::post('/male_pigs/export', [MalePigController::class, 'export'])->name(
    'male_pigs.export'
);
Route::post('/male_pigs/import', [MalePigController::class, 'import'])->name(
    'male_pigs.import'
);

// mix_infosのインポートとエクスポート
Route::post('/mix_infos/export', [MixInfoController::class, 'export'])->name(
    'mix_infos.export'
);
Route::post('/Mix_infos/import', [MixInfoController::class, 'import'])->name(
    'mix_infos.import'
);

// born_infosのインポート
Route::post('/born_infos/import', [BornInfoController::class, 'import'])->name(
    'born_infos.import'
);

// FemalePigフラグのルーティング
Route::patch('/female_pigs/{female_pig}/updateFlag', [
    FemalePigController::class,
    'updateFlag',
])->name('female_pigs.updateFlag');

// MalePigフラグのルーティング
Route::patch('/male_pigs/{male_pig}/updateFlag', [
    MalePigController::class,
    'updateFlag',
])->name('male_pigs.updateFlag');

// FemalePig再発確認のルーティング
Route::patch('/female_pigs/{female_pig}/updateRecurrence', [
    FemalePigController::class,
    'updateRecurrence',
])->name('female_pigs.updateRecurrence');

// cssテスト用
Route::get('/test', [MixInfoController::class, 'test'])->name(
    'born_infos.index'
);
