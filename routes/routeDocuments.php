<?php

use App\Example;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|    class  App\Http\Controllers\TestController
*/

Route::group([
    'middleware' => 'auth'
    ], function () {

// routes for documents

        Route::get('/documents', 'App\Http\Controllers\DocumentsController@index')->name('documents');
        Route::view('/documents/create', 'documents.create')->name('document.create');



        Route::post('/documents', 'App\Http\Controllers\DocumentsController@store')->name('document.store');


        Route::get('/documents/{slug}', 'App\Http\Controllers\DocumentsController@show')->name('document.show');
        Route::get('/documents/{slug}/edit', 'App\Http\Controllers\DocumentsController@edit')->name('document.edit');
        Route::put('/documents/{slug}', 'App\Http\Controllers\DocumentsController@update')->name('document.update');


        // test stream generation
        //  test generated content from stream
        Route::get('/filestest/stream',  'App\Http\Controllers\FilesController@downloadStream');
        // Route::get('/filestest/{file}',  'App\Http\Controllers\FilesController@testStream');

        Route::get('/filesb64/{file}',   'App\Http\Controllers\FilesController@showB64Stream')->name('file.showb64');;
        Route::get('/files/{file}',      'App\Http\Controllers\FilesController@show')->name('file.show');
        Route::get('/files/{file}/get',  'App\Http\Controllers\FilesController@download')->name('file.download');

        Route::get('/signs/{file}',      'App\Http\Controllers\SignsController@index')->name('signs.index');
        Route::post('/signs/{file}',     'App\Http\Controllers\SignsController@create')->name('signs.create');
        Route::get('/signs/{sign}/get',  'App\Http\Controllers\SignsController@download')->name('signs.download');
        Route::get('/signs/{sign}/show', 'App\Http\Controllers\SignsController@show')->name('signs.show');
        Route::post('/signs/{file}',     'App\Http\Controllers\SignsController@create')->name('signs.create');


    });
