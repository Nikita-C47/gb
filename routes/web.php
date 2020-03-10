<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

// Маршруты авторизации
Auth::routes();
// Маршруты, доступные авторизованным пользователям
Route::middleware(['auth'])->group(function () {
    // Выход из приложения
    Route::get('/logout', 'Auth\LoginController@logout')->name('logout-get');
    // Записи пользователя
    Route::get('/entries', 'EntriesController@index')->name('my-entries');
    Route::get('/entries/{id?}/edit', 'EntriesController@edit')->name('edit-entry');
    Route::post('/entries/{id?}/edit', 'EntriesController@update');
    Route::post('/entries/{id?}/delete', 'EntriesController@delete')->name('delete-entry');
    // Профиль пользователя
    Route::get('/profile', 'ProfileController@edit')->name('edit-profile');
    Route::post('/profile', 'ProfileController@update');
});
// Добавление записи
Route::get('/add', 'MainController@addEntry')->name('add-entry');
Route::post('/add', 'MainController@saveEntry');
// Главная
Route::get('/', 'MainController@index')->name('home');
