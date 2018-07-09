<?php

use Illuminate\Http\Request;
use Illuminate\Auth;
//use App\Http\Controllers\Auth\RegisterController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
    return Auth::guard('api')->user();
});

Route::post('users', ['as' => 'users.store', 'uses' => 'Auth\RegisterController@store']);
Route::post('users/login', ['as' => 'users.login', 'uses' => 'Auth\LoginController@login']);

Route::get('sites/search', [
    'as' => 'sites.search',
    'uses' => 'SitesController@search'
]);

Route::get('users/current', [
    'as' => 'users.current',
    'uses' => 'Auth\LoginController@current'
]);

Route::resource('sites', 'SitesController', [
    'except' => [ 'edit', 'create', 'index', 'show' ]
]);

Route::resource('sites', 'SitesController', [
    'only' => [  'index','show' ]
]);

Route::resource('sites/{site_id}/drills', 'DrillsController', [
    'except' => [ 'edit', 'create', 'index', 'show' ]
]);

Route::resource('sites/{site_id}/drills', 'DrillsController', [
    'only' => [ 'index' ]
]);

Route::resource('sites/{site_id}/coordinates', 'CoordinatesController', [
    'except' => ['edit', 'create']
]);

Route::resource('analyses', 'AnalysesController', [
    'only' => [ 'index', 'show', 'store', 'update', 'destroy' ]
]);

Route::resource('analyses/{analysis_id}/analysis_parameter', 'AnalysesParametersController', [
    'only' => [ 'index', 'show', 'store', 'update', 'destroy' ]
]);



Route::resource('roles', 'RolesController', [
    'except' => ['edit', 'create']
]);