<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Controllers
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\AboutController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MoreController;
use App\Http\Controllers\ServiceController;

/*
|--------------------------------------------------------------------------
| Admin Controllers
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\Admin\CalendarController;
use App\Http\Controllers\Admin\AskLibrarianController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EbookFolderController;
use App\Http\Controllers\Admin\EbookProgramController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\NewArrivalController;
use App\Http\Controllers\Admin\OpenAccessResourceController;
use App\Http\Controllers\Admin\VisitingUserController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])
    ->name('home');

Route::get('/about', [AboutController::class, 'index'])
    ->name('about');

/*
|--------------------------------------------------------------------------
| Collection Routes
|--------------------------------------------------------------------------
*/

Route::prefix('collection')
    ->name('collection.')
    ->group(function () {

        Route::get(
            '/printed',
            [CollectionController::class, 'printed']
        )->name('printed');

        Route::get(
            '/ebooks',
            [CollectionController::class, 'ebooks']
        )->name('ebooks');

        Route::get(
            '/open-access',
            [CollectionController::class, 'openAccess']
        )->name('open-access');
    });

/*
|--------------------------------------------------------------------------
| Services Routes
|--------------------------------------------------------------------------
*/

Route::prefix('services')
    ->name('services.')
    ->group(function () {

        Route::get(
            '/',
            [ServiceController::class, 'services']
        )->name('index');

        Route::get(
            '/facilities',
            [ServiceController::class, 'facilities']
        )->name('facilities');
    });

/*
|--------------------------------------------------------------------------
| More Routes
|--------------------------------------------------------------------------
*/

Route::prefix('more')
    ->name('more.')
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | Ask the Librarian
        |--------------------------------------------------------------------------
        |
        | Static public information page.
        |
        */

        Route::get(
            '/ask-librarian',
            [MoreController::class, 'askLibrarian']
        )->name('ask-librarian');

        /*
        |--------------------------------------------------------------------------
        | Gallery
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/gallery',
            [MoreController::class, 'gallery']
        )->name('gallery');

        /*
        |--------------------------------------------------------------------------
        | Visiting Researchers
        |--------------------------------------------------------------------------
        |
        | Static public information page with Google Form link.
        |
        */

        Route::get(
            '/visiting-users',
            [MoreController::class, 'visitingUsers']
        )->name('visiting-users');
    });

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

Route::middleware('guest')
    ->group(function () {

        Route::get(
            '/login',
            [AuthController::class, 'showLogin']
        )->name('login');

        Route::post(
            '/login',
            [AuthController::class, 'login']
        )->name('login.submit');

        Route::get(
            '/forgot-password',
            [AuthController::class, 'showForgotPassword']
        )->name('password.request');

        Route::post(
            '/forgot-password',
            [AuthController::class, 'sendResetLink']
        )->name('password.email');

        Route::get(
            '/reset-password/{token}',
            [AuthController::class, 'showResetPassword']
        )->name('password.reset');

        Route::post(
            '/reset-password',
            [AuthController::class, 'resetPassword']
        )->name('password.update');
    });

Route::post(
    '/logout',
    [AuthController::class, 'logout']
)
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| Administrator Routes
|--------------------------------------------------------------------------
*/

Route::prefix('admin')
    ->name('admin.')
    ->middleware('auth')
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | Dashboard
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/dashboard',
            [DashboardController::class, 'index']
        )->name('dashboard');

        Route::get(
            '/ask-librarian',
            [AskLibrarianController::class, 'index']
        )->name('ask-librarian.index');

        Route::get(
            '/visiting-users',
            [VisitingUserController::class, 'index']
        )->name('visiting-users.index');

        /*
        |--------------------------------------------------------------------------
        | Calendar Management
        |--------------------------------------------------------------------------
        */

        Route::resource(
            'calendar',
            CalendarController::class
        )->except(['show']);

        /*
        |--------------------------------------------------------------------------
        | New Arrivals Management
        |--------------------------------------------------------------------------
        */

        Route::resource(
            'new-arrivals',
            NewArrivalController::class
        )->except(['show']);

        /*
        |--------------------------------------------------------------------------
        | Gallery Management
        |--------------------------------------------------------------------------
        */

        Route::resource(
            'gallery',
            GalleryController::class
        )->except(['show']);

        /*
        |--------------------------------------------------------------------------
        | E-Book Program Management
        |--------------------------------------------------------------------------
        */

        Route::resource(
            'ebook-programs',
            EbookProgramController::class
        )->except(['show']);

        /*
        |--------------------------------------------------------------------------
        | E-Book Folder Management
        |--------------------------------------------------------------------------
        */

        Route::resource(
            'ebook-folders',
            EbookFolderController::class
        )->except(['show']);

        /*
        |--------------------------------------------------------------------------
        | Open Access Resource Management
        |--------------------------------------------------------------------------
        */

        Route::resource(
            'open-access-resources',
            OpenAccessResourceController::class
        )->except(['show']);
    });

/*
|--------------------------------------------------------------------------
| Fallback Route
|--------------------------------------------------------------------------
*/

Route::fallback(function () {
    abort(404);
});
