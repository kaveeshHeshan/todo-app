<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// Todo Lists related
Route::resource('todo_lists', 'TodoListsController');
Route::delete('/list/remove/{id}', 'TodoListsController@destroy');
Route::delete('/task/remove/{id}', 'TodoListsController@deleteTask');
