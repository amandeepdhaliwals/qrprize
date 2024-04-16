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

/*
 * Backend Routes
 * --------------------------------------------------------------------
 */
Route::group(['namespace' => '\Modules\Stores\Http\Controllers', 'middleware' => ['web', 'auth', 'can:view_backend'], 'prefix' => 'admin'], function () {
    /*
     * These routes need view_backend permission
     * (good if you want to allow more than one group in the backend,
     * then limit the backend features by different roles or permissions)
     *
     * Note: Administrator has all permissions so you do not have to specify the administrator role everywhere.
     */

    /*
     * Backend Store Routes
     * ---------------------------------------------------------------------
     */
    Route::get('stores', 'store@index')->name('stores.index');
    Route::get('stores/create', 'Store@create')->name('stores.create');
    Route::post('stores', 'Store@store')->name('stores.store');
    Route::get('stores/{id}/edit', 'Store@edit')->name('stores.edit');
    Route::get('stores/{id}', 'Store@show')->name('stores.show');
    Route::resource('stores', 'StoresController');
});
