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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/manage/{code}/{password}', 'LinkController@manage')->name('manage');
Route::get('/last-links/', 'LinkController@lastLinks')->name('last-links');
Route::get('/statistics/', 'LinkController@statistics')->name('statistics');
Route::get('/{code}', 'LinkController@redirect')->name('redirect');

