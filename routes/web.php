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
// Auth
Auth::routes();

// HomeController
Route::get('/', 'HomeController@index')->name('home');
Route::get('/last-links/', 'LinkController@lastLinks')->name('last-links');
Route::get('/statistics/', 'LinkController@statistics')->name('statistics');

// DashboardController
Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
Route::get('/dashboard/export', 'DashboardController@export')->name('dashboard.export');
Route::get('/dashboard/month', 'DashboardController@month')->name('dashboard.month');

// ManageController
Route::get('/manage/{code}/{password}', 'ManageController@index')->name('manage');
Route::get('/manage/title/{code}/{password}', 'ManageController@title')->name('manage.title');
Route::get('/manage/export/{code}/{password}', 'ManageController@export')->name('manage.export');
Route::get('/manage/qr-code/{code}/{password}', 'ManageController@qrcode')->name('manage.qrcode');
Route::get('/manage/browser/{code}/{password}', 'ManageController@browser')->name('manage.browser');
Route::get('/manage/platform/{code}/{password}', 'ManageController@platform')->name('manage.platform');
Route::get('/manage/country/{code}/{password}', 'ManageController@country')->name('manage.country');

// ProfileController
Route::get('/profile', 'ProfileController@index')->name('profile');
Route::post('/profile/update', 'ProfileController@update')->name('profile.update');
Route::post('/profile/renew-token', 'ProfileController@renewToken')->name('profile.renew-token');
Route::post('/profile/password', 'ProfileController@password')->name('profile.password');

// Admin Control
Route::prefix(config('7ul.admin-url'))->name('admin.')->group(function () {
    Route::get('/', 'Admin\DashboardController@index')->name('dashboard');
    Route::get('/dashboard/month', 'Admin\DashboardController@month')->name('dashboard.month');
});

// LinkController
Route::post('/shorten', 'LinkController@shorten')->name('shorten');
Route::get('/{code}', 'LinkController@redirect')->name('redirect');

