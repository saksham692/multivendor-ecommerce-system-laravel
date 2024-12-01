<?php

use App\Http\Controllers\AttributeController;
use App\Http\Controllers\FooterGridThreeController;
use App\Http\Controllers\FooterGridTwoController;
use App\Http\Controllers\FooterInfoController;
use App\Http\Controllers\FooterSocialController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LabelController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "admin" middleware group. Make something great!
|
*/
Route::group(['prefix' => 'admin', 'middleware' => ['auth'], 'as' => 'admin.'], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('backend.dashboard');

    Route::group(['prefix' => 'product'], function () {
        /** Categories */
        Route::post('/categories/change-active-status', [CategoryController::class, 'changeActiveStatus'])->name('product.categories.changeActiveStatus');
        Route::resource('categories', CategoryController::class)->names('product.categories');

        /** Brands */
        Route::post('/brands/change-featured-status', [BrandController::class, 'changeFeaturedStatus'])->name('product.brands.changeFeaturedStatus');
        Route::post('/brands/change-active-status', [BrandController::class, 'changeActiveStatus'])->name('product.brands.changeActiveStatus');
        Route::resource('brands', BrandController::class)->names('product.brands');

        /** Attributes */
        Route::post('/attributes/change-active-status', [AttributeController::class, 'changeActiveStatus'])->name('product.attributes.changeActiveStatus');
        Route::resource('attributes', AttributeController::class)->names('product.attributes');

        /** Collections */
        Route::post('/collections/change-featured-status', [CollectionController::class, 'changeFeaturedStatus'])->name('product.collections.changeFeaturedStatus');
        Route::post('/collections/change-active-status', [CollectionController::class, 'changeActiveStatus'])->name('product.collections.changeActiveStatus');
        Route::resource('collections', CollectionController::class)->names('product.collections');

        /** Labels */
        Route::post('/labels/change-featured-status', [LabelController::class, 'changeFeaturedStatus'])->name('product.labels.changeFeaturedStatus');
        Route::post('/labels/change-active-status', [LabelController::class, 'changeActiveStatus'])->name('product.labels.changeActiveStatus');
        Route::resource('labels', LabelController::class)->names('product.labels');

    });

    /** Home Page Setting */
    Route::controller(\App\Http\Controllers\HomePageSettingController::class)->group(function () {
        Route::get('/home-page-setting', 'index')->name('home-page-setting');
        Route::post('/home-page-setting/main-banner/add', 'main_banner_add')->name('home-page-setting.add-main-banner');
//        Route::post('/home-page-setting/main-banner/edit', 'main_banner_edit')->name('home-page-setting.edit-main-banner');
//        Route::post('/home-page-setting/main-banner/update', 'main_banner_update')->name('home-page-setting.update-main-banner');
        Route::post('/home-page-setting/main-banner/remove', 'main_banner_remove')->name('home-page-setting.remove-main-banner');
        Route::post('/home-page-setting/banner-section-one', 'banner_section_one')->name('home-page-setting.banner-section-one');
        Route::post('/home-page-setting/banner-section-two', 'banner_section_two')->name('home-page-setting.banner-section-two');
        Route::post('/home-page-setting/banner-section-three', 'banner_section_three')->name('home-page-setting.banner-section-three');
        Route::post('/home-page-setting/banner-section-four', 'banner_section_four')->name('home-page-setting.banner-section-four');
    });

    /** Add Pages */
    Route::resource('pages', PageController::class);

    /** Products */
    Route::post('/products/get-attribute-values', [ProductController::class, 'getAttributeValues'])->name('products.getAttributeValues');
    Route::post('/products/change-active-status', [ProductController::class, 'changeActiveStatus'])->name('products.changeActiveStatus');
    Route::resource('products', ProductController::class)->names('products');

    /** Sellers */
    Route::get('/seller/{id}/profile', [SellerController::class, 'sellerProfile'])->name('sellers.profile');
    Route::get('/sellers/pending-applications', [SellerController::class, 'pendingSellers'])->name('sellers.pending');
    Route::post('/seller/approve', [SellerController::class, 'approveSeller'])->name('sellers.approve');
    Route::post('/seller/reject', [SellerController::class, 'rejectSeller'])->name('sellers.reject');
    Route::resource('sellers', SellerController::class)->names('sellers');

    /** Permissions */
    Route::resource('permissions', PermissionController::class)->names('permissions');

    /** Roles */
    Route::get('/roles/{role}/assign-permissions', [RoleController::class, 'assignPermissions'])->name('roles.permissions.assign');
    Route::post('/roles/{role}/assign-permissions', [RoleController::class, 'updatePermissions'])->name('roles.permissions.update');
    Route::resource('roles', RoleController::class)->names('roles');

    /** footer routes */
    Route::resource('footer-info', FooterInfoController::class);
    Route::put('footer-socials/change-status', [FooterSocialController::class, 'changeStatus'])->name('footer-socials.change-status');
    Route::resource('footer-socials', FooterSocialController::class);

    Route::put('footer-grid-two/change-status', [FooterGridTwoController::class, 'changeStatus'])->name('footer-grid-two.change-status');
    Route::put('footer-grid-two/change-title', [FooterGridTwoController::class, 'changeTitle'])->name('footer-grid-two.change-title');
    Route::resource('footer-grid-two', FooterGridTwoController::class);

    Route::put('footer-grid-three/change-status', [FooterGridThreeController::class, 'changeStatus'])->name('footer-grid-three.change-status');
    Route::put('footer-grid-three/change-title', [FooterGridThreeController::class, 'changeTitle'])->name('footer-grid-three.change-title');
    Route::resource('footer-grid-three', FooterGridThreeController::class);

    /** Users */
    Route::resource('users', UserController::class)->names('users');

    /** Settings routes */
    Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
    Route::put('generale-setting-update', [SettingController::class, 'generalSettingUpdate'])->name('generale-setting-update');
    Route::put('email-setting-update', [SettingController::class, 'emailConfigSettingUpdate'])->name('email-setting-update');
    Route::put('logo-setting-update', [SettingController::class, 'logoSettingUpdate'])->name('logo-setting-update');
    Route::put('pusher-setting-update', [SettingController::class, 'pusherSettingUpdate'])->name('pusher-setting-update');


});
