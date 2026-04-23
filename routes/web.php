<?php

use App\Http\Controllers\Backend\Admin\AdminListingController;
use App\Http\Controllers\Backend\Admin\BusinessListingExportController;
use App\Http\Controllers\Backend\Admin\CategoryController;
use App\Http\Controllers\Backend\Admin\CityController;
use App\Http\Controllers\Backend\Admin\GeneralSettingController;
use App\Http\Controllers\Backend\Admin\GoogleRecaptchaController;
use App\Http\Controllers\Backend\Admin\ManageLoginHistoryController;
use App\Http\Controllers\Backend\Admin\PackageController;
use App\Http\Controllers\Backend\Admin\PostController;
use App\Http\Controllers\Backend\Admin\RoleController;
use App\Http\Controllers\Backend\Admin\SeoManagerController;
use App\Http\Controllers\Backend\Admin\SMTPSettingController;
use App\Http\Controllers\Backend\Admin\SocialLoginController;
use App\Http\Controllers\Backend\Admin\SocialMediaController;
use App\Http\Controllers\Backend\Admin\SubcategoryController;
use App\Http\Controllers\Backend\Admin\SystemInfoController;
use App\Http\Controllers\Backend\Admin\UploadPhotoFromEditorController;
use App\Http\Controllers\Backend\Admin\UserController;
use App\Http\Controllers\Backend\Business\BusinessDashboardController;
use App\Http\Controllers\Backend\Business\BusinessEventController;
use App\Http\Controllers\Backend\Business\BusinessListingController;
use App\Http\Controllers\Backend\Business\PostJobListingController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Frontend\BlogPageController;
use App\Http\Controllers\Frontend\BusinessEventPageController;
use App\Http\Controllers\Frontend\HomepageController;
use App\Http\Controllers\Frontend\BusinessListingPageController;
use App\Http\Controllers\Frontend\JobPageController;
use App\Http\Controllers\Frontend\Tools\InvoiceDownloadController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


//Public routes
Route::get('/', [HomepageController::class, 'index']);

Route::get('/business/categories', [BusinessListingPageController::class, 'browseByCategories'])->name('browse.business.categories');
Route::get('/business/{listingSlug}', [BusinessListingPageController::class, 'businessDetail'])->name('listing.details');
Route::get('/business/category/{slug}', [BusinessListingPageController::class, 'byCategory'])->name('business.by.category');
Route::get('/business/subcategory/{slug}', [BusinessListingPageController::class, 'bySubcategory'])->name('business.by.subcategory');
Route::get('business/city/{slug}', [BusinessListingPageController::class, 'byCity'])->name('business.by.city');
Route::get('/business', [BusinessListingPageController::class, 'allBusinesses'])->name('listing.all');
Route::get('/search', [BusinessListingPageController::class, 'businessSearch'])->name('business.search');


Route::get('/upcomming-events/{slug}', [BusinessEventPageController::class, 'eventDetail'])->name('event.detail');
Route::get('/upcomming-events', [BusinessEventPageController::class, 'allEvents'])->name('event.all');


Route::get('/jobs-in-tanzania/sector/{slug}', [JobPageController::class, 'jobsBySector'])->name('jobs.by.sector');
Route::get('/jobs-in-tanzania/city/{slug}', [JobPageController::class, 'jobsByCity'])->name('jobs.by.city');
Route::get('/jobs-in-tanzania/type/{slug}', [JobPageController::class, 'jobsByType'])->name('jobs.by.type');
Route::get('/jobs-in-tanzania/{slug}', [JobPageController::class, 'jobDetail'])->name('job.detail');
Route::get('/jobs-in-tanzania', [JobPageController::class, 'allJobs'])->name('job.all');



Route::get('/blog/{slug}/', [BlogPageController::class, 'postDetails'])->name('post.details');
Route::get('/blog/category/{slug}', [BlogPageController::class, 'postsByCategory'])->name('posts.byCategory');
Route::get('/blog/tag/{slug}', [BlogPageController::class, 'postsByTag'])->name('posts.byTag');
Route::get('/blog/author/{username}', [BlogPageController::class, 'postsByUser'])->name('posts.byUser');
Route::get('/blog', [BlogPageController::class, 'allPosts']);


Route::prefix('tools')->group(function () {
    Route::view('/invoice-generator/history', 'frontend.tools.history')->name('tools.invoice.history');
    Route::post('/invoice-generator/download', InvoiceDownloadController::class)->name('tools.invoice.download');
    Route::get('/invoice-generator', [InvoiceDownloadController::class, 'index'])->name('tools.invoice');
});

Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard
    Route::middleware(['role:admin|manager|editor|writer'])->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    });

    // Business Owner Dashboard
    Route::middleware(['role:business_owner'])->group(function () {
        Route::get('my-business/dashboard', [BusinessDashboardController::class, 'index'])->name('business_owner.dashboard');
    });

    // Business Listings owner
    Route::middleware(['permission:create.business_listings|update.business_listings|delete.business_listings|manage.business_listings'])->group(function () {

        Route::get('/getSubCategories', [CategoryController::class, 'getSubCategories']);
        Route::get('/business-listings', [BusinessListingController::class, 'index'])->name('business-listings.index');
        Route::get('/business-listings/create', [BusinessListingController::class, 'create'])->name('business-listings.add');
        Route::get('/business-listings/{listing}/edit', [BusinessListingController::class, 'edit'])->name('business-listings.edit');
    });

    // categories
    Route::middleware(['permission:create.categories|update.categories|delete.categories|manage.categories'])->group(function () {
        Route::get('categories/export', [CategoryController::class, 'export'])->name('categories.export');
        Route::resource('categories', CategoryController::class)->except(['show']);

        Route::get('subcategories/export', [SubCategoryController::class, 'export'])->name('subcategories.export');
        Route::resource('subcategories', SubcategoryController::class)->except(['show']);
    });


    Route::middleware(['permission:view.posts|create.posts|update.posts|delete.posts|manage.posts|publish.posts'])->group(function () {

        Route::resource('posts', PostController::class)->except(['show']);
        Route::post('posts/bulk-delete', [PostController::class, 'bulkDelete'])->name('posts.bulk-delete');
        Route::post('posts/{post}/toggle-status', [PostController::class, 'toggleStatus'])
            ->name('posts.toggle-status');
        Route::post('/editor/image/upload', [UploadPhotoFromEditorController::class, 'imageUpload'])->name('editor.image.upload');
    });

    Route::middleware(['permission:create.cities|update.cities|delete.cities|manage.cities'])->group(function () {
        Route::resource('cities', CityController::class)->except(['show']);
    });

     Route::middleware(['permission:create.events|update.events|delete.events|manage.events'])->group(function () {
        Route::resource('events', BusinessEventController::class)->except(['show']);
    });

     Route::middleware(['permission:create.jobs|update.jobs|delete.jobs|manage.jobs'])->group(function () {
        Route::resource('jobs', PostJobListingController::class)->except(['show']);
    });

    Route::middleware(['permission:create.social_medias|update.social_medias|delete.social_medias|manage.social_medias'])->group(function () {
        Route::resource('socialmedias', SocialMediaController::class)->except(['show']);
    });

    // Business Listings admin
    Route::middleware(['role:admin|manager'])->group(function () {
        Route::get('listings/export', [BusinessListingExportController::class, 'export'])->name('listings.export');
        Route::resource('listings', AdminListingController::class)->except(['show']);
    });

    // Profile
    Route::middleware(['role:admin|manager|business_owner|editor|writer'])->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    });

    Route::middleware(['permission:create.roles|update.roles|delete.roles|manage.roles'])->group(function () {
        Route::resource('roles', RoleController::class)->except(['show']);
    });

    Route::middleware(['permission:create.packages|update.packages|delete.packages|manage.packages'])->group(function () {
        Route::resource('packages', PackageController::class);
    });

    Route::middleware(['permission:create.users|update.users|manage.users|delete.users'])->group(function () {
        Route::get('users/export', [UserController::class, 'export'])->name('users.export');
        Route::resource('users', UserController::class);
    });

    Route::middleware(['permission:view.login_history'])->group(function () {

        Route::get('/login-history/export', [ManageLoginHistoryController::class, 'export'])->name('login-history.export');
        Route::get('/login-history/pdf', [ManageLoginHistoryController::class, 'exportPdf'])->name('login.history.export.pdf');
        Route::get('/login-history/excel', [ManageLoginHistoryController::class, 'exportExcel'])->name('login.history.export.excel');
        Route::get('/login-history', [ManageLoginHistoryController::class, 'index'])->name('login.history');
        
    });

    // General settings
    Route::middleware(['permission:manage.seo|manage.general_settings'])->group(function () {

        Route::get('/mail-setting', [SMTPSettingController::class, 'index'])->name('mail.settings');
        Route::post('/mail-setting/update', [SMTPSettingController::class, 'update'])->name('update.mail.settings');

        Route::get('/google-recaptcha', [GoogleRecaptchaController::class, 'index'])->name('google.recaptcha');
        Route::post('/google-recaptcha/update', [GoogleRecaptchaController::class, 'update'])->name('update.google.recaptcha');

        Route::get('/system-info', SystemInfoController::class)->name('system.info');

        Route::get('general-setting', [GeneralSettingController::class, 'index'])->name('general.settings');
        Route::post('general-setting/store', [GeneralSettingController::class, 'store'])->name('store.general.settings');

        Route::get('/social-login', [SocialLoginController::class, 'index'])->name('social.login.settings');
        Route::post('/social-login', [SocialLoginController::class, 'update'])->name('update.social.login.settings');
    });

    Route::middleware(['permission:manage.seo'])->group(function () {

        Route::get('seo-manager', [SeoManagerController::class, 'index'])->name('seo');
        Route::post('seo/store', [SeoManagerController::class, 'store'])->name('store.seo');
    });
});

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

require __DIR__ . '/auth.php';
