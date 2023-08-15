<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CmsPackageController;
use App\Http\Controllers\FTPCategoryController;
use App\Http\Controllers\FTPController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Artisan;
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

Route::get('/clear', function () {
    Artisan::call('cache:clear');
    return "Cache Cleared";
});
Route::get('/storage', function () {
    Artisan::call('storage:link');
    return "storage Linked";
});
Route::middleware(['guest'])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/ftp', [HomeController::class, 'ftp'])->name('home.ftp');
    Route::get('/packages', [HomeController::class, 'packages'])->name('home.packages');
    Route::get('login', [AuthController::class, 'index'])->name('login');
    Route::post('login', [AuthController::class, 'postLogin'])->name('login');
});

Route::middleware('auth')->group(function () {
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
});


Route::middleware(['auth', 'admin'])->group(function () {

    Route::prefix('admin')->name('admin.')->group(function () {

        Route::get('dashboard', [AuthController::class, 'dashboard'])->name('home');

        Route::prefix('setting')->name('setting.')->group(function () {
            Route::get('/', [SettingController::class, 'index'])->name('index');
            Route::post('create', [SettingController::class, 'store'])->name('store');
        });
        Route::prefix('profile')->name('profile.')->group(function () {
            Route::get('/', [ProfileController::class, 'index'])->name('index');
            Route::post('create', [ProfileController::class, 'update'])->name('store');
            Route::post('password', [ProfileController::class, 'updatePassword'])->name('password');
        });






        Route::prefix('cms')->name('cms.')->group(function () {
            Route::prefix('home/page')->name('home.page.')->group(function () {
                Route::get('/', [HomeController::class, 'edit'])->name('index');
                Route::post('create', [HomeController::class, 'store'])->name('store');
            });
            # code...
            Route::prefix('ftp/category')->name('ftp.category.')->group(function () {
                Route::get('/', [FTPCategoryController::class, 'index'])->name('index');
                Route::get('/create', [FTPCategoryController::class, 'create'])->name('create');
                Route::post('/create', [FTPCategoryController::class, 'store'])->name('store');
                Route::get('/edit/{category}', [FTPCategoryController::class, 'edit'])->name('edit');
                Route::put('/edit/{category}', [FTPCategoryController::class, 'update'])->name('update');
                Route::delete('/delete/{category}', [FTPCategoryController::class, 'destroy'])->name('destroy');
            });

            Route::prefix('ftp')->name('ftp.')->group(function () {
                Route::get('/', [FTPController::class, 'index'])->name('index');
                Route::get('/create', [FTPController::class, 'create'])->name('create');
                Route::post('/create', [FTPController::class, 'store'])->name('store');
                Route::get('/edit/{ftp}', [FTPController::class, 'edit'])->name('edit');
                Route::put('/edit/{ftp}', [FTPController::class, 'update'])->name('update');
                Route::delete('/delete/{ftp}', [FTPController::class, 'destroy'])->name('destroy');
                Route::post('/status/change', [FTPController::class, 'statusChange'])->name('statusChange');
            });

            Route::prefix('slider')->name('slider.')->group(function () {
                Route::get('/', [SliderController::class, 'index'])->name('index');
                Route::get('/create', [SliderController::class, 'create'])->name('create');
                Route::post('/create', [SliderController::class, 'store'])->name('store');
                Route::get('/edit/{ftp}', [SliderController::class, 'edit'])->name('edit');
                Route::put('/edit/{ftp}', [SliderController::class, 'update'])->name('update');
                Route::delete('/delete/{ftp}', [SliderController::class, 'destroy'])->name('destroy');
            });

            Route::prefix('team')->name('team.')->group(function () {
                Route::get('/', [TeamController::class, 'index'])->name('index');
                Route::get('/create', [TeamController::class, 'create'])->name('create');
                Route::post('/create', [TeamController::class, 'store'])->name('store');
                Route::get('/edit/{ftp}', [TeamController::class, 'edit'])->name('edit');
                Route::put('/edit/{ftp}', [TeamController::class, 'update'])->name('update');
                Route::delete('/delete/{ftp}', [TeamController::class, 'destroy'])->name('destroy');
            });
            Route::resource('cms-package', CmsPackageController::class);
        });
    });
});
