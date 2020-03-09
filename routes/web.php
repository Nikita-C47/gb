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

//Auth::routes();

Route::get('/add', 'MainController@addEntry')->name('add-entry');
Route::post('/add', 'MainController@saveEntry');

Route::get('/', 'MainController@index')->name('home');
