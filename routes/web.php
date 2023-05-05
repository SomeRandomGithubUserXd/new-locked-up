<?php

use App\Http\Controllers\AppealController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\Certificates\CertificateController;
use App\Http\Controllers\Certificates\CertificateInstanceController;
use App\Http\Controllers\Locations\LocationController;
use App\Http\Controllers\Locations\LocationLoungeController;
use App\Http\Controllers\Lounges\LoungeController;
use App\Http\Controllers\Lounges\LoungeScheduleController;
use App\Http\Controllers\Lounges\LoungeScheduleItemController;
use App\Http\Controllers\ModalsController;
use App\Http\Controllers\News\NewsController;
use App\Http\Controllers\Orders\OrderController;
use App\Http\Controllers\Orders\OrderFilterController;
use App\Http\Controllers\Orders\OrderPaymentController;
use App\Http\Controllers\Orders\OrderSourceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Quests\ChildQuestTopicController;
use App\Http\Controllers\Quests\PerformanceQuestController;
use App\Http\Controllers\Quests\QuestController;
use App\Http\Controllers\Quests\QuestPerformanceExperimentController;
use App\Http\Controllers\Quests\QuestPerformanceLoadController;
use App\Http\Controllers\Quests\QuestPerformanceLoungeController;
use App\Http\Controllers\Quests\QuestPerformanceShowController;
use App\Http\Controllers\Quests\QuestTopicController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\Schedules\ScheduleController;
use App\Http\Controllers\Schedules\ScheduleItemController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\UserController;
use App\Models\Quests\QuestPerformanceShow;
use App\Providers\RouteServiceProvider;
use App\Services\RouteConstructor;

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
        new PerformanceQuestController('performance-quests'),
        new LocationController('locations'),
        new ServiceController('services'),
        new ScheduleController('schedules'),
        new QuestTopicController('quest-topics'),
        new ChildQuestTopicController('child-quest-topics'),
        new CertificateInstanceController('certificate-instances'),
        new SaleController('sales'),
        new ReviewController('reviews'),
        new OrderSourceController('order-sources'),
        new LoungeController('lounges'),
        new LoungeScheduleController('lounge-schedules'),
    );
    // Catalog misc
    Route::resource('locations.location_lounges', LocationLoungeController::class);
    Route::resource('quests.quest_performance_shows', QuestPerformanceShowController::class);
    Route::resource('quests.quest_performance_loads', QuestPerformanceLoadController::class);
    Route::resource('quests.quest_performance_experiments', QuestPerformanceExperimentController::class);
    Route::resource('quests.quest_performance_lounges', QuestPerformanceLoungeController::class);

    // Certificate instances additional
    Route::group(['prefix' => 'certificate-instances', 'as' => 'certificate-instances.'], function () {
        Route::post('/upload', [CertificateInstanceController::class, 'upload'])->name('upload');
    });

    // Users
    RouteConstructor::resourcesWithMultipleDeletion(
        new UserController('users')
    );

    // News
    RouteConstructor::resourcesWithMultipleDeletion(
        new NewsController('news')
    );

    // Modals
    Route::group(['prefix' => '/modals', 'as' => 'modals.'], function () {
        Route::get('/main', [ModalsController::class, 'main'])->name('main');
        Route::patch('/update_advert_modal', [ModalsController::class, 'updateAdvertModal'])->name('update-advert-modal');
    });

    // Settings
    Route::group(['prefix' => '/settings', 'as' => 'settings.'], function () {
        Route::get('/', [SettingsController::class, 'index'])->name('index');
    });

    // Quest additional routes
    Route::group(['prefix' => 'orders', 'as' => 'orders.'], static function () {
        Route::group(['prefix' => '{order}'], static function () {
            Route:: get('/view_logs', [OrderController::class, 'viewLogs'])->name('view-logs');
            Route::group(['prefix' => 'payments', 'as' => 'payments.'], static function () {
                Route::get('/', [OrderPaymentController::class, 'index'])->name('index');
                Route::get('/create', [OrderPaymentController::class, 'create'])->name('create');
                Route::post('/store', [OrderPaymentController::class, 'store'])->name('store');
            });
        });
    });
    Route::group(['prefix' => 'quests', 'as' => 'quests.'], static function () {
        Route::group(['prefix' => '{quest}'], static function () {
            Route::get('/get_quest_meta', [QuestController::class, 'getQuestMeta'])->name('get-quest-meta');
        });
    });
    Route::group(['prefix' => 'schedule-items', 'as' => 'schedule-items.'], static function () {
        Route::group(['prefix' => '{id}'], static function () {
            Route::delete('/destroy', [ScheduleItemController::class, 'destroy'])->name('destroy');
        });
        Route::group(['prefix' => '{schedule}'], static function () {
            Route::get('/', [ScheduleItemController::class, 'index'])->name('index');
            Route::post('/', [ScheduleItemController::class, 'store'])->name('store');
        });
    });
    Route::group(['prefix' => 'lounge-schedule-items', 'as' => 'lounge-schedule-items.'], static function () {
        Route::group(['prefix' => '{id}'], static function () {
            Route::delete('/destroy', [LoungeScheduleItemController::class, 'destroy'])->name('destroy');
        });
        Route::group(['prefix' => '{loungeSchedule}'], static function () {
            Route::get('/', [LoungeScheduleItemController::class, 'index'])->name('index');
            Route::post('/', [LoungeScheduleItemController::class, 'store'])->name('store');
        });
    });
    // Default laravel routes, feel free to remove if required
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
require __DIR__ . '/auth.php';
