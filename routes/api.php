<?php

use Illuminate\Http\Request;

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

Route::group(['middleware' => ['auth:api']], function () {
    Route::get('draw', 'DrawController@index');
    Route::get('draw/{categorie}/show', 'SorteoController@index')->name('draw.index');
    Route::get('draw/update', 'SorteoController@draw')->name('draw.update');
});