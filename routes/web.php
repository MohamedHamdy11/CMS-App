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

Route::group(['middleware' => 'auth'], function(){
    Route::get('/home', 'HomeController@index')->name('home');
    // categories
    Route::resource('/categories','CategoriesController');
    // tegs
    Route::resource('/tags', 'TagsController');
    // posts
    Route::resource('/posts','PostsController');
    Route::get('/trashed-posts','PostsController@trashed')->name('trashed.index');
    Route::get('/trashed-posts/{id}', 'PostsController@restore')->name('trashed.restore');
    // user edit 
    Route::get('/users/{user}/profile', 'UsersController@edit')->name('users.edit');
    Route::post('/users/{user}/profile', 'UsersController@update')->name('users.update');

}); // end of route auth


Route::middleware(['auth', 'admin'])->group(function() {
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
    Route::get('/users', 'UsersController@index')->name('users.index');
    Route::post('/users/{user}/make-admin', 'UsersController@makeAdmin')->name('users.make-admin');
    Route::post('/users/{user}/make-writer', 'UsersController@makeWriter')->name('users.make-writer');

}); // end of auth and admin

