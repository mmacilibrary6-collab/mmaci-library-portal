<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| Models
|--------------------------------------------------------------------------
*/

use App\Models\NewArrival;

/*
|--------------------------------------------------------------------------
| Public Controllers
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\AboutController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\LisaController;
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
use App\Http\Controllers\Admin\ThesisFolderController;
use App\Http\Controllers\Admin\ThesisProgramController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\DonatedBookController;
use App\Http\Controllers\Admin\PeriodicalFolderController;
use App\Http\Controllers\Admin\PeriodicalProgramController;
use App\Http\Controllers\Admin\LibraryUpdateController;
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

Route::redirect('/mmaci', '/', 301);
Route::redirect('/library', '/', 301);

/*
|--------------------------------------------------------------------------
| Public Media
|--------------------------------------------------------------------------
*/

Route::get('/media', function () {

    $path = trim((string) request()->query('path', ''));

    $path = str_replace('\\', '/', $path);

    $path = ltrim($path, '/');

    abort_unless(
        $path !== '' && Storage::disk('public')->exists($path),
        404
    );

    return response()->file(
        Storage::disk('public')->path($path)
    );

})->name('public.media');

/*
|--------------------------------------------------------------------------
| About
|--------------------------------------------------------------------------
*/

Route::get('/about', [AboutController::class, 'index'])
    ->name('about');

/*
|--------------------------------------------------------------------------
| Lisa AI Assistant
|--------------------------------------------------------------------------
*/

Route::post('/lisa/message', [LisaController::class, 'message'])
    ->name('lisa.message');

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
            '/thesis-and-dissertation',
            [CollectionController::class, 'theses']
        )->name('theses');

        Route::get(
            '/open-access',
            [CollectionController::class, 'openAccess']
        )->name('open-access');

        Route::get(
            '/subscribed-database',
            [CollectionController::class, 'subscribedDatabase']
        )->name('subscribed-database');

        Route::get(
            '/donated-books',
            [CollectionController::class, 'donatedBooks']
        )->name('donated-books');

        Route::get(
            '/periodicals',
            [CollectionController::class, 'periodicals']
        )->name('periodicals');

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
        | New Arrivals
        |--------------------------------------------------------------------------
        */

        Route::get('/new-arrivals', function () {

            $arrivals = NewArrival::orderByDesc('arrival_date')
                ->orderByDesc('id')
                ->get();

            return view('more.new-arrivals', compact('arrivals'));

        })->name('new-arrivals');

        /*
        |--------------------------------------------------------------------------
        | Visiting Researchers
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/visiting-users',
            [MoreController::class, 'visitingUsers']
        )->name('visiting-users');

        /*
        |--------------------------------------------------------------------------
        | Online Book Recommendation
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/online-book-recommendation',
            [MoreController::class, 'onlineBookRecommendation']
        )->name('online-book-recommendation');

        /*
        |--------------------------------------------------------------------------
        | Reserve AVR
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/reserve-avr',
            [MoreController::class, 'reserveAvr']
        )->name('reserve-avr');

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

/*
|--------------------------------------------------------------------------
| Logout
|--------------------------------------------------------------------------
*/

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

        /*
        |--------------------------------------------------------------------------
        | Ask Librarian
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/ask-librarian',
            [AskLibrarianController::class, 'index']
        )->name('ask-librarian.index');

        /*
        |--------------------------------------------------------------------------
        | Visiting Users
        |--------------------------------------------------------------------------
        */

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
        | Donated Books
        |--------------------------------------------------------------------------
        */

        Route::resource(
            'donated-books',
            DonatedBookController::class
        )->except(['show']);

        /*
        |--------------------------------------------------------------------------
        | Periodicals
        |--------------------------------------------------------------------------
        */

        Route::resource(
            'periodical-programs',
            PeriodicalProgramController::class
        )->except(['show']);

        Route::resource(
            'periodical-folders',
            PeriodicalFolderController::class
        )->except(['show']);

        /*
        |--------------------------------------------------------------------------
        | Gallery Images
        |--------------------------------------------------------------------------
        */

        Route::post(
            'gallery/{gallery}/images',
            [GalleryController::class, 'storeImage']
        )->name('gallery.images.store');

        /*
        |--------------------------------------------------------------------------
        | E-Book Programs
        |--------------------------------------------------------------------------
        */

        Route::resource(
            'ebook-programs',
            EbookProgramController::class
        )->except(['show']);

        /*
        |--------------------------------------------------------------------------
        | Thesis Programs
        |--------------------------------------------------------------------------
        */

        Route::resource(
            'thesis-programs',
            ThesisProgramController::class
        )->except(['show']);

        /*
        |--------------------------------------------------------------------------
        | E-Book Folders
        |--------------------------------------------------------------------------
        */

        Route::resource(
            'ebook-folders',
            EbookFolderController::class
        )->except(['show']);

        /*
        |--------------------------------------------------------------------------
        | Thesis Folders
        |--------------------------------------------------------------------------
        */

        Route::resource(
            'thesis-folders',
            ThesisFolderController::class
        )->except(['show']);

        /*
        |--------------------------------------------------------------------------
        | Library Updates
        |--------------------------------------------------------------------------
        */

        Route::resource(
            'library-updates',
            LibraryUpdateController::class
        )->except(['show']);

        /*
        |--------------------------------------------------------------------------
        | Open Access Resources
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