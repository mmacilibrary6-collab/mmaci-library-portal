<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| Models
|--------------------------------------------------------------------------
*/

use App\Models\NewArrival;
use App\Models\LibraryUpdate;
use App\Models\DonatedBook;
use App\Models\EbookProgram;
use App\Models\Gallery;
use App\Models\GalleryImage;
use App\Models\OpenAccessResource;
use App\Models\PeriodicalProgram;
use App\Models\ThesisProgram;
use App\Support\MediaStorage;

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
use App\Http\Controllers\Admin\VisitorIpAddressController;
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

Route::get('/database-media/{type}/{id}', function (string $type, int $id) {
    $models = [
        'new-arrival' => NewArrival::class,
        'library-update' => LibraryUpdate::class,
        'donated-book' => DonatedBook::class,
        'ebook-program' => EbookProgram::class,
        'gallery' => Gallery::class,
        'gallery-image' => GalleryImage::class,
        'open-access-resource' => OpenAccessResource::class,
        'periodical-program' => PeriodicalProgram::class,
        'thesis-program' => ThesisProgram::class,
    ];

    abort_unless(isset($models[$type]), 404);

    $image = $models[$type]::query()
        ->whereKey($id)
        ->value('image');

    abort_if(blank($image), 404);

    if (str_starts_with($image, 'http://') || str_starts_with($image, 'https://')) {
        return redirect()->away($image);
    }

    if (!str_starts_with($image, 'data:') && MediaStorage::exists($image)) {
        return redirect()->to(MediaStorage::url($image));
    }

    $mimeType = 'application/octet-stream';
    $contents = $image;

    if (str_starts_with($image, 'data:')) {
        preg_match('/^data:([^;,]+);base64,(.*)$/s', $image, $matches);
        abort_unless(count($matches) === 3, 404);

        $mimeType = $matches[1];
        $contents = base64_decode($matches[2], true);
        abort_if($contents === false, 404);
    } else {
        $detectedType = (new finfo(FILEINFO_MIME_TYPE))->buffer($contents);
        if (is_string($detectedType) && str_starts_with($detectedType, 'image/')) {
            $mimeType = $detectedType;
        }
    }

    return response($contents, 200, [
        'Content-Type' => $mimeType,
        'Cache-Control' => 'public, max-age=604800, immutable',
        'X-Content-Type-Options' => 'nosniff',
    ]);
})->whereNumber('id')->name('database.media');

/*
|--------------------------------------------------------------------------
| About
|--------------------------------------------------------------------------
*/

Route::get('/about', [AboutController::class, 'index'])
    ->name('about');

Route::get('/ask-librarian', function () {
    return redirect()->route('more.ask-librarian', status: 301);
})->name('ask-librarian.redirect');

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

        /*
        |--------------------------------------------------------------------------
        | Survey
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/survey',
            [MoreController::class, 'survey']
        )->name('survey');

        Route::redirect(
            '/new-arrivals',
            '/collection/new-arrivals',
            301
        )->name('new-arrivals');

    });

/*
|--------------------------------------------------------------------------
| Collection New Arrivals
|--------------------------------------------------------------------------
*/

Route::get('/collection/new-arrivals', function () {

    $search = trim((string) request()->query('search', ''));

    $arrivals = NewArrival::query()
        ->when($search !== '', function ($query) use ($search) {
            $query->where(function ($builder) use ($search) {
                $builder
                    ->where('title', 'like', "%{$search}%")
                    ->orWhere('author', 'like', "%{$search}%")
                    ->orWhere('accession_number', 'like', "%{$search}%")
                    ->orWhere('category', 'like', "%{$search}%");
            });
        })
        ->orderByDesc('arrival_date')
        ->orderByDesc('id')
        ->paginate(12)
        ->withQueryString();

    return view('collection.new-arrivals', compact('arrivals', 'search'));

})->name('collection.new-arrivals');

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

        Route::get(
            '/visitor-ip-address',
            [VisitorIpAddressController::class, 'index']
        )->name('visitor-ip-address.index');

        Route::post(
            '/visitor-ip-address/prune',
            [VisitorIpAddressController::class, 'prune']
        )->name('visitor-ip-address.prune');

        Route::post(
            '/visitor-ip-address/clear-today',
            [VisitorIpAddressController::class, 'clearToday']
        )->name('visitor-ip-address.clear-today');

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

        Route::delete(
            'gallery/{gallery}/images/{galleryImage}',
            [GalleryController::class, 'destroyImage']
        )->name('gallery.images.destroy');

        Route::delete(
            'gallery/{gallery}/images',
            [GalleryController::class, 'destroyImages']
        )->name('gallery.images.bulk-destroy');

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
