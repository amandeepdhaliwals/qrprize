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
Route::group(['namespace' => '\Modules\Stores\Http\Controllers\Backend','as' => 'backend.','middleware' => ['web', 'auth', 'can:view_backend'], 'prefix' => 'admin'], function () {
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
    $module_name = 'stores';
    $controller_name = 'StoresController';
    Route::get("{$module_name}/index_list", ['as' => "{$module_name}.index_list", 'uses' => "{$controller_name}@index_list"]);
    Route::get("{$module_name}/index_data", ['as' => "{$module_name}.index_data", 'uses' => "{$controller_name}@index_data"]);
    Route::get("{$module_name}/create", ['as' => "{$module_name}.create", 'uses' => "{$controller_name}@create"]);
    Route::get("{$module_name}/{storeId?}/pardeep", ['as' => "{$module_name}.pardeep", 'uses' => "{$controller_name}@pardeep"]);
    Route::post("{$module_name}", ['as' => "{$module_name}.store", 'uses' => "{$controller_name}@store"]);
    Route::get("{$module_name}/{id}/edit", ['as' => "{$module_name}.edit", 'uses' => "{$controller_name}@edit"]);
    Route::get("{$module_name}/{id}", ['as' => "{$module_name}.show", 'uses' => "{$controller_name}@show"]);
    Route::get("{$module_name}/trashed", ['as' => "{$module_name}.trashed", 'uses' => "{$controller_name}@trashed"]);
    Route::patch("{$module_name}/trashed/{id}", ['as' => "{$module_name}.restore", 'uses' => "{$controller_name}@restore"]);

    Route::resource("{$module_name}", "{$controller_name}");
    Route::get("{$module_name}/{storeId}/add-campaign", ['as' => "{$module_name}.add-campaign", 'uses' => "{$controller_name}@addCampaign"]);
    Route::post("{$module_name}/storeCampaign", ['as' => "{$module_name}.storeCampaign", 'uses' => "{$controller_name}@storeCampaign"]);
    Route::get("{$module_name}/{storeId}/campaign_index", ['as' => "{$module_name}.campaign_index", 'uses' => "{$controller_name}@campaignIndex"]);

    Route::get("{$module_name}/{storeId}/edit-campaign/{campaignId}", ['as' => "{$module_name}.edit-campaign", 'uses' => "{$controller_name}@editCampaign"]);
    Route::post("{$module_name}/updateCampaign", ['as' => "{$module_name}.updateCampaign", 'uses' => "{$controller_name}@updateCampaign"]);


});
