<?php

use App\Http\Controllers\AppealController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\Orders\OrderController;
use App\Http\Controllers\Orders\OrderFilterController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Quests\QuestController;
use App\Http\Controllers\ScheduleItemController;
use App\Http\Controllers\UserController;
use App\Providers\RouteServiceProvider;
use App\Services\RouteConstructor;
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

    Route::resource('bookings', BookingController::class);
    // Booking additional routes
    Route::group(['prefix' => 'bookings', 'as' => 'bookings.'], static function () {
        Route::group(['prefix' => '{scheduleId}'], static function () {
            Route::patch('/make', [BookingController::class, 'make'])->name('make');
            Route::patch('/undo', [BookingController::class, 'undo'])->name('undo');
        });
    });
    RouteConstructor::resourcesWithMultipleDeletion(
        new OrderController('orders'),
        new AppealController('appeals'),
        new CertificateController('certificates'),
        new OrderFilterController('order-filters'),
    );

    // Catalog category
    RouteConstructor::resourcesWithMultipleDeletion(
        new QuestController('quests'),
    );
    // Quest additional routes
    Route::group(['prefix' => 'quests', 'as' => 'quests.'], static function () {
        Route::group(['prefix' => '{quest}'], static function () {
            Route::get('/get_quest_meta', [QuestController::class, 'getQuestMeta'])->name('get-quest-meta');
        });
    });

    Route::group(['prefix' => 'schedule-items', 'as' => 'schedule-items.'], static function () {
        Route::group(['prefix' => '{schedule}'], static function () {
            Route::get('/', [ScheduleItemController::class, 'index'])->name('index');
        });
    });
    // Default laravel routes, feel free to remove if required
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
require __DIR__ . '/auth.php';
