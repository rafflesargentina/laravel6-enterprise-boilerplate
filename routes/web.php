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

Auth::routes();

Route::get('/auth/{provider}', 'Auth\SocialController@redirectToProvider');
Route::get('/{catchall?}', 'HomeController')->where('catchall', '^(?!api).*$')->name('home');

Route::post('/auth/{provider}/callback', 'Auth\SocialController@handleProviderCallback');
