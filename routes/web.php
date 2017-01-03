<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Auth::routes();

Route::get('/home', 'HomeController@index');
Route::post('/home/requestNote', 'HomeController@RequestSubmit');

Route::get('logout', function (){Auth::logout();return redirect('/login');});

Route::get('/noteDetail/{noteid}', 'HomeController@NoteDetail');
Route::post('/home/updateNote', 'HomeController@UpdateNote');

Route::post('/home/shareSelectedUsers', 'HomeController@ShareNote');
Route::get('/noteDetail/shareAllUsers/{noteid}', 'HomeController@ShareNoteToAll');

Route::get('/noteDetail/delete/{noteid}', 'HomeController@DeleteNote');
Route::get('/noteDetail/activate/{noteid}', 'HomeController@ActivateNote');








