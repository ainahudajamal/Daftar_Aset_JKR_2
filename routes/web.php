<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ComponentController;
use App\Http\Controllers\MainComponentController;
use App\Http\Controllers\SubComponentController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\KodBinaanLuarController;
use App\Http\Controllers\MasterDataController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SistemController;
use App\Http\Controllers\SubsistemController;
use App\Http\Controllers\Admin\AdminComponentController as AdminComponentController;
use App\Http\Controllers\Admin\BlokController;

/*
|--------------------------------------------------------------------------
| Guest Routes (Login Page - Redirect if already logged in)
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post'); // ✅ MOVED HERE!
});

/*
|--------------------------------------------------------------------------
| Authenticated Routes (Require Login)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Change Password
    Route::get('/change-password', [AuthController::class, 'showChangePasswordForm'])->name('password.change.form');
    Route::post('/change-password', [AuthController::class, 'changePassword'])->name('password.change');

    /*
    |--------------------------------------------------------------------------
    | Dashboard (Default - Redirect based on role)
    |--------------------------------------------------------------------------
    */
    Route::get('/', function () {
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('components.index');
    })->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | Admin Dashboard & Management (Admin Only)
    |--------------------------------------------------------------------------
    */
    Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
        // Dashboard
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::get('/user-activity', [AdminDashboardController::class, 'userActivity'])->name('user-activity');
        Route::get('/system-stats', [AdminDashboardController::class, 'systemStats'])->name('system-stats');

        // User Management
        Route::resource('users', UserController::class);
        Route::post('users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');
        Route::get('users/{user}/reset-password', [UserController::class, 'showResetPasswordForm'])->name('users.reset-password');
        Route::post('users/{user}/reset-password', [UserController::class, 'resetPassword'])->name('users.reset-password.post');

        // Sistem Management
        Route::get('sistem', [SistemController::class, 'index'])->name('sistem.index');
        Route::get('sistem/create', [SistemController::class, 'create'])->name('sistem.create');
        Route::post('sistem', [SistemController::class, 'store'])->name('sistem.store');
        Route::get('sistem/{sistem}/edit', [SistemController::class, 'edit'])->name('sistem.edit');
        Route::put('sistem/{sistem}', [SistemController::class, 'update'])->name('sistem.update');
        Route::delete('sistem/{sistem}', [SistemController::class, 'destroy'])->name('sistem.destroy');
        Route::get('sistem/{sistem}/subsistems', [SistemController::class, 'subsistems'])->name('sistem.subsistems');

        // Subsistem Management
        Route::get('sistem/{sistem}/subsistems/create', [SubsistemController::class, 'create'])->name('sistem.subsistems.create');
        Route::post('sistem/{sistem}/subsistems', [SubsistemController::class, 'store'])->name('sistem.subsistems.store');
        Route::get('sistem/{sistem}/subsistems/{subsistem}/edit', [SubsistemController::class, 'edit'])->name('sistem.subsistems.edit');
        Route::put('sistem/{sistem}/subsistems/{subsistem}', [SubsistemController::class, 'update'])->name('sistem.subsistems.update');
        Route::delete('sistem/{sistem}/subsistems/{subsistem}', [SubsistemController::class, 'destroy'])->name('sistem.subsistems.destroy');

        // Blok Management
        Route::get('blok', [BlokController::class, 'index'])->name('blok.index');
        Route::get('blok/create', [BlokController::class, 'create'])->name('blok.create');
        Route::post('blok', [BlokController::class, 'store'])->name('blok.store');
        Route::get('blok/{blok}/edit', [BlokController::class, 'edit'])->name('blok.edit');
        Route::put('blok/{blok}', [BlokController::class, 'update'])->name('blok.update');
        Route::delete('blok/{blok}', [BlokController::class, 'destroy'])->name('blok.destroy');

        // Component Management (Admin)
        Route::prefix('components')->name('components.')->group(function () {
            Route::get('/', [AdminComponentController::class, 'index'])->name('index');
            Route::get('/statistics', [AdminComponentController::class, 'statistics'])->name('statistics');
            Route::get('/trashed', [AdminComponentController::class, 'trashed'])->name('trashed');
            Route::get('/{component}', [AdminComponentController::class, 'show'])->name('show');
            Route::delete('/{component}', [AdminComponentController::class, 'destroy'])->name('destroy');
            Route::patch('/{component}/toggle-status', [AdminComponentController::class, 'toggleStatus'])->name('toggle-status');
            Route::post('/{id}/restore', [AdminComponentController::class, 'restore'])->name('restore');
            Route::delete('/{id}/force-delete', [AdminComponentController::class, 'forceDelete'])->name('force-delete');
            Route::post('/bulk-action', [AdminComponentController::class, 'bulkAction'])->name('bulk-action');
        });
    });

    /*
    |--------------------------------------------------------------------------
    | API Routes untuk Autofill & Master Data
    |--------------------------------------------------------------------------
    */
    Route::prefix('api')->name('api.')->group(function () {
        Route::post('/check-kod-blok', [MasterDataController::class, 'checkKodBlok'])->name('check-kod-blok');
        Route::post('/check-kod-aras', [MasterDataController::class, 'checkKodAras'])->name('check-kod-aras');
        Route::post('/check-kod-sistem', [MasterDataController::class, 'checkKodSistem'])->name('check-kod-sistem');
        Route::post('/check-kod-subsistem', [MasterDataController::class, 'checkKodSubSistem'])->name('check-kod-subsistem');
        Route::post('/save-kod-blok', [MasterDataController::class, 'saveKodBlok'])->name('save-kod-blok');
        Route::post('/save-kod-aras', [MasterDataController::class, 'saveKodAras'])->name('save-kod-aras');
        Route::get('/master-data/{type}', [MasterDataController::class, 'getMasterData'])->name('master-data');
    });

    /*
    |--------------------------------------------------------------------------
    | Component Routes (Borang 1) - User Dashboard & CRUD
    |--------------------------------------------------------------------------
    */
    Route::prefix('components')->name('components.')->group(function () {
        Route::get('/', [ComponentController::class, 'index'])->name('index');
        Route::get('/trashed', [ComponentController::class, 'trashed'])->name('trashed');
        Route::post('/{id}/restore', [ComponentController::class, 'restore'])->name('restore');
        Route::delete('/{id}/force-delete', [ComponentController::class, 'forceDestroy'])->name('force-destroy');
        Route::get('/create', [ComponentController::class, 'create'])->name('create');
        Route::post('/', [ComponentController::class, 'store'])->name('store');
        Route::get('/{component}', [ComponentController::class, 'show'])->name('show');
        Route::get('/{component}/edit', [ComponentController::class, 'edit'])->name('edit');
        Route::put('/{component}', [ComponentController::class, 'update'])->name('update');
        Route::delete('/{component}', [ComponentController::class, 'destroy'])->name('delete');
    });

    /*
    |--------------------------------------------------------------------------
    | Main Component Routes (Borang 2)
    |--------------------------------------------------------------------------
    */
    Route::prefix('main-components')->name('main-components.')->group(function () {
        Route::get('/generate-kod-lokasi', [MainComponentController::class, 'generateKodLokasi'])->name('generate-kod-lokasi');
        Route::get('/trashed', [MainComponentController::class, 'trashed'])->name('trashed');
        Route::post('/{id}/restore', [MainComponentController::class, 'restore'])->name('restore');
        Route::delete('/{id}/force-delete', [MainComponentController::class, 'forceDestroy'])->name('force-destroy');
        Route::get('/create', [MainComponentController::class, 'create'])->name('create');
        Route::post('/', [MainComponentController::class, 'store'])->name('store');
        Route::get('/{mainComponent}', [MainComponentController::class, 'show'])->name('show');
        Route::get('/{mainComponent}/edit', [MainComponentController::class, 'edit'])->name('edit');
        Route::put('/{mainComponent}', [MainComponentController::class, 'update'])->name('update');
        Route::delete('/{mainComponent}', [MainComponentController::class, 'destroy'])->name('delete');
    });

    /*
    |--------------------------------------------------------------------------
    | Sub Component Routes (Borang 3)
    |--------------------------------------------------------------------------
    */
    Route::prefix('sub-components')->name('sub-components.')->group(function () {
        Route::get('/trashed', [SubComponentController::class, 'trashed'])->name('trashed');
        Route::post('/{id}/restore', [SubComponentController::class, 'restore'])->name('restore');
        Route::delete('/{id}/force-delete', [SubComponentController::class, 'forceDestroy'])->name('force-destroy');
        Route::get('/create', [SubComponentController::class, 'create'])->name('create');
        Route::post('/', [SubComponentController::class, 'store'])->name('store');
        Route::get('/{subComponent}', [SubComponentController::class, 'show'])->name('show');
        Route::get('/{subComponent}/edit', [SubComponentController::class, 'edit'])->name('edit');
        Route::put('/{subComponent}', [SubComponentController::class, 'update'])->name('update');
        Route::delete('/{subComponent}', [SubComponentController::class, 'destroy'])->name('delete');
    });

    /*
    |--------------------------------------------------------------------------
    | Kod Binaan Luar Routes (Master Data)
    |--------------------------------------------------------------------------
    */
    Route::prefix('kod-binaan-luar')->name('kod-binaan-luar.')->group(function () {
        Route::get('/api/aktif', [KodBinaanLuarController::class, 'getAktif'])->name('api.aktif');
        Route::get('/api/search', [KodBinaanLuarController::class, 'search'])->name('api.search');
        Route::get('/', [KodBinaanLuarController::class, 'index'])->name('index');
        Route::get('/create', [KodBinaanLuarController::class, 'create'])->name('create');
        Route::post('/', [KodBinaanLuarController::class, 'store'])->name('store');
        Route::get('/{kodBinaanLuar}', [KodBinaanLuarController::class, 'show'])->name('show');
        Route::get('/{kodBinaanLuar}/edit', [KodBinaanLuarController::class, 'edit'])->name('edit');
        Route::put('/{kodBinaanLuar}', [KodBinaanLuarController::class, 'update'])->name('update');
        Route::delete('/{kodBinaanLuar}', [KodBinaanLuarController::class, 'destroy'])->name('destroy');
    });

    /*
    |--------------------------------------------------------------------------
    | Export Routes - PDF & Excel
    |--------------------------------------------------------------------------
    */
    Route::prefix('export')->name('export.')->group(function () {
        Route::get('/component/{component}/pdf', [ExportController::class, 'exportComponentPDF'])->name('component.pdf');
        Route::get('/component/{component}/excel', [ExportController::class, 'exportComponentExcel'])->name('component.excel');
        Route::get('/main-component/{mainComponent}/pdf', [ExportController::class, 'exportMainComponentPDF'])->name('main-component.pdf');
        Route::get('/main-component/{mainComponent}/excel', [ExportController::class, 'exportMainComponentExcel'])->name('main-component.excel');
        Route::get('/sub-component/{subComponent}/pdf', [ExportController::class, 'exportSubComponentPDF'])->name('sub-component.pdf');
        Route::get('/sub-component/{subComponent}/excel', [ExportController::class, 'exportSubComponentExcel'])->name('sub-component.excel');
        Route::get('/complete-report/{component}/pdf', [ExportController::class, 'exportCompleteReportPDF'])->name('complete-report.pdf');
        Route::get('/complete-report/{component}/excel', [ExportController::class, 'exportCompleteReportExcel'])->name('complete-report.excel');
        Route::get('/all-components/pdf', [ExportController::class, 'exportAllComponentsPDF'])->name('all-components.pdf');
        Route::get('/all-components/excel', [ExportController::class, 'exportAllComponentsExcel'])->name('all-components.excel');
    });
}); // End of auth middleware