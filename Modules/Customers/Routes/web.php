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
Route::group(['namespace' => '\Modules\Customers\Http\Controllers\Backend','as' => 'backend.','middleware' => ['web', 'auth', 'can:view_backend'], 'prefix' => 'admin'], function () {
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
    $module_name = 'customers';
    $controller_name = 'CustomersController';
    Route::match(['get', 'post'], "{$module_name}/stats/filter", ['as' => "{$module_name}.stats.filter", 'uses' => "{$controller_name}@stats"]);
    Route::get("{$module_name}/stats", ['as' => "{$module_name}.stats", 'uses' => "{$controller_name}@stats"]);
    Route::get("{$module_name}/claimed", ['as' => "{$module_name}.claimed", 'uses' => "{$controller_name}@claimed"]);
    Route::get("{$module_name}/claimed_data", ['as' => "{$module_name}.claimed_data", 'uses' => "{$controller_name}@claimed_data"]);
    Route::get("{$module_name}/update_claim/{claimId}", ['as' => "{$module_name}.update_claim", 'uses' => "{$controller_name}@update_claim"]);
    Route::post("{$module_name}/update_shipping_status", ['as' => "{$module_name}.update_shipping_status", 'uses' => "{$controller_name}@update_shipping_status"]);
    Route::post("{$module_name}/exportToExcel", ['as' => "{$module_name}.exportToExcel", 'uses' => "{$controller_name}@exportToExcel"]);
    Route::get("{$module_name}/index", ['as' => "{$module_name}.index", 'uses' => "{$controller_name}@index"]);
    Route::get("{$module_name}/index_list", ['as' => "{$module_name}.index_list", 'uses' => "{$controller_name}@index_list"]);
    Route::get("{$module_name}/index_data", ['as' => "{$module_name}.index_data", 'uses' => "{$controller_name}@index_data"]);
    Route::get("{$module_name}/index_data_cust", ['as' => "{$module_name}.index_data_cust", 'uses' => "{$controller_name}@index_data_cust"]);
    Route::get("{$module_name}/visitor", ['as' => "{$module_name}.visitor", 'uses' => "{$controller_name}@visitor"]);
    Route::get("{$module_name}/visitor_data", ['as' => "{$module_name}.visitor_data", 'uses' => "{$controller_name}@visitor_data"]);
    Route::get("{$module_name}/create", ['as' => "{$module_name}.create", 'uses' => "{$controller_name}@create"]);
    Route::post("{$module_name}", ['as' => "{$module_name}.store", 'uses' => "{$controller_name}@store"]);
    Route::get("{$module_name}/{id}/edit", ['as' => "{$module_name}.edit", 'uses' => "{$controller_name}@edit"]);
    Route::get("{$module_name}/{id}", ['as' => "{$module_name}.show", 'uses' => "{$controller_name}@show"]);
    Route::get("{$module_name}/trashed", ['as' => "{$module_name}.trashed", 'uses' => "{$controller_name}@trashed"]);
    Route::patch("{$module_name}/trashed/{id}", ['as' => "{$module_name}.restore", 'uses' => "{$controller_name}@restore"]);


    Route::resource("{$module_name}", "{$controller_name}");

});
