<?php

use App\Article;
use App\Agency;

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
Auth::routes();

// Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
// Route::post('login', 'Auth\LoginController@login');
// Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// // // Password Reset Routes...
// Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
// Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
// Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm');
// Route::post('password/reset', 'Auth\ResetPasswordController@reset');



Route::group(['middleware' => 'auth'], function (){
	
	Route::get('password/change', 'UserManagementController@changePassword')->name('password.change');
	Route::post('password/update', 'UserManagementController@updatePassword')->name('password.update');
	
	//Inyeccion de dependencia para agregar los productos
	Route::bind('product', function ($cod) {
		return Article::where('cod', $cod)->first();
	});
	
	Route::get('/', function () {
		return view('dashboard');
	})->middleware('auth');
	
	Route::get('dashboard', 'DashboardController@index')->name('dashboard');
	Route::get('index-seller', 'DashboardController@indexSeller')->name('index.seller');
	Route::get('chart-sold', 'DashboardController@getChartSold')->name('chart.sold');
	//Route::post('chart-sold', 'DashboardController@getChartSold')->name('chart.sold');
	
	Route::resource('categorie', 'CategorieController');
	Route::get('article/{category}', 'ArticleController@index')->name('article.index');
	Route::resource('article', 'ArticleController', ['except' => [ 'index' ]]);
	
	/******************************* AGENCY ************************************************/
	Route::resource('agency', 'AgencyController');
	Route::post('agency/activate/{id}', 'AgencyController@activate')->name('agency.activate');
	
	/******************************* SALES ************************************************/
	Route::resource('client', 'ClientController');
	Route::get('sale/{category}', 'SaleController@index')->name('sale.index');
	Route::post('sale/add/{product}', 'SaleController@add')->name('sale.add');
	Route::get('sale/delete/{producto}', 'SaleController@delete')->name('sale.delete');
	Route::get('sale/trash/{category}', 'SaleController@trash')->name('sale.trash');
	Route::post('sale/process', 'SaleController@process')->name('sale.process');
	Route::get('sale/report', 'SaleController@report')->name('sale.report');
	Route::post('sale/anular/{category}', 'SaleController@anular')->name('sale.anular');
	Route::post('sale/pagar/{category}', 'SaleController@pagar')->name('sale.pagar');
	/******************************* END ************************************************/
	
	Route::resource('usermanagement', 'UserManagementController');
	Route::get('profile', 'ProfileController@profile')->name('profile');
	
	/*************************** Cart *************************************/
	
	Route::get('cart/show', 'CartController@show')->name('cart.show');
	Route::get('cart/add/{product}', 'CartController@add')->name('cart.add');
	Route::get('cart/delete/{product}', 'CartController@delete')->name('cart.delete');

});



