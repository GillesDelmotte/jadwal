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





Route::delete('/teachers/{id}', 'TeacherController@destroy')->middleware('auth');

Route::post('/sessions/sendEmails', 'SessionController@sendEmails')->middleware('auth');



Route::get('/sessions/create', 'SessionController@create')->middleware('auth');
Route::get('/teachers/create', 'TeacherController@create')->middleware('auth');
Route::post('/sessions', 'SessionController@store')->middleware('auth');
Route::post('/teachers', 'TeacherController@store')->middleware('auth');
Route::post('/modals', 'ModalController@store');


Route::get('/sessions/{session}', 'SessionController@show')->middleware('auth');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/sessions/fillModals/{token}', 'SessionController@fillModals');
