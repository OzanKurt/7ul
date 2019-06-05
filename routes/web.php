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



Route::get('/', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
Route::get('/dashboard/export', 'DashboardController@export')->name('dashboard.export');
Route::get('/manage/{code}/{password}', 'ManageController@index')->name('manage');
Route::get('/manage/title/{code}/{password}', 'ManageController@title')->name('manage.title');
Route::get('/manage/export/{code}/{password}', 'ManageController@export')->name('manage.export');
Route::post('/shorten', 'LinkController@shorten')->name('shorten');
Route::get('/last-links/', 'LinkController@lastLinks')->name('last-links');
Route::get('/statistics/', 'LinkController@statistics')->name('statistics');
Route::get('/{code}', 'LinkController@redirect')->name('redirect');

