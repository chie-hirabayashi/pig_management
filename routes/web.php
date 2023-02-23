<?php

use App\Http\Controllers\ExtractController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FemalePigController;
use App\Http\Controllers\MalePigController;
use App\Http\Controllers\MixInfoController;
use App\Http\Controllers\ImportExportController;
use App\Http\Controllers\AchievementController;
use App\Http\Controllers\PlaceController;

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

Route::get('/', [FemalePigController::class, 'index'])->name('root');

Route::get('/dashboard', function () {
    return view('dashboard');
})
    ->middleware(['auth'])
    ->name('dashboard');

require __DIR__ . '/auth.php';

// 基本のルーティング
Route::resource('female_pigs', FemalePigController::class)
    ->only(['create', 'store', 'edit', 'update', 'destroy'])
    ->middleware(['auth']);
Route::resource('female_pigs', FemalePigController::class)->only([
    'index',
    'show',
]);

Route::resource('male_pigs', MalePigController::class)
    ->only(['create', 'store', 'edit', 'update', 'destroy'])
    ->middleware(['auth']);
Route::resource('male_pigs', MalePigController::class)->only(['index', 'show']);

Route::resource('female_pigs.mix_infos', MixInfoController::class)
    ->only(['create', 'store', 'edit', 'update', 'destroy'])
    ->middleware(['auth']);

Route::resource('places', PlaceController::class);
// FIXME:livewireへ
// Route::patch('/places/{place}/put', [
    // PlaceController::class,'put'])->name('places.put');

use App\Http\Livewire\PlaceIn;
Route::get('place-in', PlaceIn::class)->name('livewire.place-in');

// 出産情報に関するルーティング
Route::get('/mix_infos/{mix_info}/create', [
    MixInfoController::class,
    'createBorn',
])
    ->middleware(['auth'])
    ->name('born_infos.create'); //createという名のedit

Route::patch('/mix_infos/{mix_info}/store', [
    MixInfoController::class,
    'storeBorn',
])
    ->middleware(['auth'])
    ->name('born_infos.store'); //storeという名のpatch

Route::get('/mix_infos/{mix_info}/edit', [MixInfoController::class, 'editBorn'])
    ->middleware(['auth'])
    ->name('born_infos.edit');

Route::patch('/mix_infos/{mix_info}/update', [
    MixInfoController::class,
    'updateBorn',
])
    ->middleware(['auth'])
    ->name('born_infos.update');

Route::patch('/mix_infos/{mix_info}/delete', [
    MixInfoController::class,
    'destroyBorn',
])
    ->middleware(['auth'])
    ->name('born_infos.destroy'); //deleteという名のpatch

// 抽出のルーティング
Route::post('/extracts', [ExtractController::class, 'index'])->name(
    'extracts.index'
);
Route::get('/extracts/conditions', [
    ExtractController::class,
    'conditions',
])->name('extracts.conditions');

// インポートフォーム
Route::get('/imports_exports/form', [ImportExportController::class, 'form'])
    ->middleware(['auth'])
    ->name('imports_exports.form');
// female_pigsのインポートとエクスポート
Route::post('/female_pigs/export', [FemalePigController::class, 'export'])
    ->middleware(['auth'])
    ->name('female_pigs.export');
Route::post('/female_pigs/import', [FemalePigController::class, 'import'])
    ->middleware(['auth'])
    ->name('female_pigs.import');
// male_pigsのインポートとエクスポート
Route::post('/male_pigs/export', [MalePigController::class, 'export'])
    ->middleware(['auth'])
    ->name('male_pigs.export');
Route::post('/male_pigs/import', [MalePigController::class, 'import'])
    ->middleware(['auth'])
    ->name('male_pigs.import');
// mix_infosのインポートとエクスポート
// Route::post('/mix_infos/export', [MixInfoController::class, 'export'])->name(
Route::get('/mix_infos/export', [MixInfoController::class, 'export'])
    ->middleware(['auth'])
    ->name('mix_infos.export');
Route::post('/Mix_infos/import', [MixInfoController::class, 'import'])
    ->middleware(['auth'])
    ->name('mix_infos.import');

// FemalePigフラグのルーティング
Route::patch('/female_pigs/{female_pig}/updateFlag', [
    FemalePigController::class,
    'updateFlag',
])
    ->middleware(['auth'])
    ->name('female_pigs.updateFlag');
// MalePigフラグのルーティング
Route::patch('/male_pigs/{male_pig}/updateFlag', [
    MalePigController::class,
    'updateFlag',
])
    ->middleware(['auth'])
    ->name('male_pigs.updateFlag');

// FemalePig再発確認のルーティング
Route::patch('/female_pigs/{female_pig}/updateRecurrence', [
    FemalePigController::class,
    'updateRecurrence',
])
    ->middleware(['auth'])
    ->name('female_pigs.updateRecurrence');

// 総合実績表
Route::get('/achievements', [AchievementController::class, 'index'])
    ->middleware(['auth'])
    ->name('achievements.index');
Route::get('/achievements/show', [AchievementController::class, 'show'])
    ->middleware(['auth'])
    ->name('achievements.show');

// cssテスト用
Route::get('/test', [MixInfoController::class, 'test'])->name(
    'born_infos.index'
);

