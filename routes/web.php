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


Route::get('/', 'bandsController@index')->name('bands');
Route::get('/bands/create', 'bandsController@create')->name('bands.create');
Route::post('/bands/store', 'bandsController@store')->name('bands.store');
Route::post('/bands/update', 'bandsController@update')->name('bands.update');
Route::get('/bands/edit/{id}', 'bandsController@edit')->name('bands.edit');
Route::get('/bands/datatables', 'bandsController@dataTables')->name('bands.datatables');
Route::delete('/bands/delete/{id}', 'bandsController@delete')->name('bands.delete');

Route::get('/albums', 'albumsController@index')->name('albums');
Route::get('/albums/create', 'albumsController@create')->name('albums.create');
Route::post('/albums/store', 'albumsController@store')->name('albums.store');
Route::post('/albums/update', 'albumsController@update')->name('albums.update');
Route::get('/albums/edit/{id}', 'albumsController@edit')->name('albums.edit');
Route::get('/albums/datatables', 'albumsController@dataTables')->name('albums.datatables');
Route::delete('/albums/delete/{id}', 'albumsController@delete')->name('albums.delete');

