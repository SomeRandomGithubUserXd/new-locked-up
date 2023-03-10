<?php

use App\Http\Controllers\AppealController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\Orders\OrderController;
use App\Http\Controllers\Orders\OrderFilterController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Quests\QuestController;
use App\Models\Orders\OrderFilter;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Route;

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

Route::redirect('/', RouteServiceProvider::HOME);
Route::middleware('auth')->group(function () {
    // Orders category
    Route::resources([
        'orders' => OrderController::class,
        'appeals' => AppealController::class,
        'certificates' => CertificateController::class,
        'bookings' => BookingController::class,
        'order-filters' => OrderFilterController::class,
    ]);
    Route::group(['prefix' => 'orders', 'as' => 'orders.'], function () {
        Route::post('delete_many', [OrderController::class, 'destroyMany'])->name('destroy-many');
    });
    Route::group(['prefix' => 'appeals', 'as' => 'appeals.'], function () {
        Route::post('delete_many', [AppealController::class, 'destroyMany'])->name('destroy-many');
    });

    // Catalog category
    Route::resources([
        'orders' => OrderController::class,
    ]);

    // Quest additional routes
    Route::group(['prefix' => 'quests', 'as' => 'quests.'], function () {
        Route::group(['prefix' => '{quest}'], function () {
            Route::get('/get_quest_meta', [QuestController::class, 'getQuestMeta'])->name('get-quest-meta');
        });
    });
    Route::group(['prefix' => 'bookings', 'as' => 'bookings.'], function () {
        Route::group(['prefix' => '{scheduleId}'], function () {
            Route::patch('/make', [BookingController::class, 'make'])->name('make');
            Route::patch('/undo', [BookingController::class, 'undo'])->name('undo');
        });
    });

    // Default laravel routes, feel free to remove if required
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
require __DIR__ . '/auth.php';
