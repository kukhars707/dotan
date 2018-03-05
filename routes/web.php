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

Route::group([
    'namespace' => 'App',
    'middleware' => 'check.url'
], function () {
    Route::get('/', 'HomeController@index')->name('home.index');
    Route::get('/kartinki', 'GalleryController@all')->name('gallery.all');
    Route::get('/video', 'VideoController@all')->name('video.all');
    Route::get('/stati', 'ArticleController@all')->name('stati.all');
    Route::get('/gaydy', 'ManualController@all')->name('manual.all');
    Route::get('/{url}', 'ChoiceController@choiceController');
});

### Admins ###
Route::group(['prefix' => 'olegadmin', 'middleware' => ['admin'], 'namespace' => 'Admin'], function () {
    CRUD::resource('article', 'ArticleCrudController');
    CRUD::resource('images', 'ImageCrudController');
    CRUD::resource('videos', 'VideoCrudController');
    CRUD::resource('manuals', 'ManualCrudController');
    CRUD::resource('article-category', 'ArticleCategoryCrudController');
    CRUD::resource('video-category', 'VideoCategoryCrudController');
    CRUD::resource('image-category', 'ImageCategoryCrudController');
});