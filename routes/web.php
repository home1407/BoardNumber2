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

Route::resource('boards', 'BoardsController');

Route::resource('comments', 'CommentsController');

Route::get('myArticles', 'BoardsController@myArticles');

Route::get('search', 'BoardsController@search')->name('search');

Route::get('/redirect', 'SocialAuthGoogleController@redirect');

Route::get('/callback', 'SocialAuthGoogleController@callback');

Route::resource('attachments', 'AttachmentsController', ['only'=>['store', 'destroy']]);

Route::get('outlog', '\App\Http\Controllers\Auth\LoginController@logout')->name('outlog');
