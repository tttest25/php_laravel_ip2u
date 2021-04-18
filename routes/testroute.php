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


Route::get('/testc', 'App\Http\Controllers\TestController@home');


Route::get('/testdb', function (App\Example $example) {
    // special test route - deubg bar
    // $example = app()->make(App\Example::class);

    //  debug bar
    $arr = [1, 2, 3];

    Debugbar::debug($arr);
    Debugbar::info($arr);
    Debugbar::notice($arr);
    Debugbar::warning($arr);
    Debugbar::error($arr);
    Debugbar::critical($arr);
    Debugbar::alert($arr);
    Debugbar::emergency($arr);

    Debugbar::addMessage($arr, 'customized-label');

    try {
        throw new Exception('foobar');
    } catch (Exception $e) {
        Debugbar::addThrowable($e);
    }

    start_measure('render', 'Time for rendering');
    stop_measure('render');
    add_measure('now', LARAVEL_START, microtime(true));
    measure('My long operation', function () {
        sleep(1);
    });


    xdebug_info();
    //ddd([ $example]);
});


// ТЕСТ api JSON
Route::get('/testapi', fn () =>  array('testh' => 'testv'));




// test request params
Route::get('test1', function () {
    $name = request('name','deault');
    return view('test', ['name' => $name]);
});

// test slugs as part of uri
Route::get('test2/{post}', function ($post) {
    $name = request('name','empty_name_param');
    $content =  array('post1' =>  "post1cont", 'post2' => "post2cont");
    if (! array_key_exists($post,$content)) {
        abort(404,"not found data");
    }
    return view('test', ['name' => $name,'slug' => $post, "content"=> $content[$post] ?? 'no content']);
});


// test controller
Route::get('test/{post}', 'App\Http\Controllers\TestController@showPost');



Route::get('file-upload', 'App\Http\Controllers\TestController@fileUpload')->name('file.upload');
Route::post('file-upload', 'App\Http\Controllers\TestController@fileUploadPost')->name('file.upload.post');

// Route::view('testsign/{fileid}', 'fileSign', ['fileid' => $fileid])->name('test.sign.view');
Route::get('testsign/{fileid}', function($fileid){
    return view('fileSign', ['fileid' => $fileid]);
})->name('test.sign.view');

Route::post('testsign', 'App\Http\Controllers\TestController@testSign')->name('test.sign');
