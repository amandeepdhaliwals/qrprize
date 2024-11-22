<?php

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


Route::group([
    'namespace' => '\Modules\Mobilesettings\Http\Controllers\Backend',
    'as' => 'backend.mobilesettings.',
    'middleware' => ['web', 'auth', 'can:view_backend'],
    'prefix' => 'admin'
], function () {

    Route::get('mobilesettings/coins', ['as' => 'coins', 'uses' => 'MobilesettingsController@coins']);
    Route::get('mobilesettings/coins/{id}/edit', ['as' => 'coins.edit', 'uses' => 'MobilesettingsController@editCoin']);
    Route::post('mobilesettings/coins/{id}', ['as' => 'coins.update', 'uses' => 'MobilesettingsController@updateCoin']);
    Route::resource('mobilesettings', MobilesettingsController::class)->except(['show']);

    Route::get('mobilesettings/site-info', ['as' => 'mobilesettings.site_info', 'uses' => 'MobilesettingsController@manageSiteInfo']);
    Route::post('mobilesettings/site-info', ['as' => 'mobilesettings.update_site_info', 'uses' => 'MobilesettingsController@updateSiteInfo']);
    
    // Route for managing site info
    Route::get('mobilesettings/site-info', [
        'as' => 'site_info',
        'uses' => 'MobilesettingsController@manageSiteInfo'
    ]);

    // Route for updating site info (POST method)
    Route::post('mobilesettings/site-info', [
        'as' => 'update_site_info',
        'uses' => 'MobilesettingsController@updateSiteInfo'
    ]);

    // Route::get('mobilesettings/site-info', [ MobilesettingsController::class, 'manageSiteInfo'])->name('mobilesettings.manage_site_info');

});

