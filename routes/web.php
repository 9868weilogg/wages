<?php

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

Route::get('/', function () {
    return view('welcome');
});

Route::resource('home','HomeController');
Route::resource('valuations','ValuationsController');
Route::resource('admins','AdminsController');
Route::resource('eods','EndOfDayDatasController');
// Route::get('/plans','PlansController@index')->name('plans.index');
// Route::get('/plans/{plan}','PlansController@show')->name('plans.show');
Route::resource('plans','PlansController');
Route::resource('subscriptions','SubscriptionsController');
Route::get('/braintree/token', 'BraintreeTokenController@index')->name('token');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
