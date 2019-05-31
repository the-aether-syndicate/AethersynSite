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

Route::get('/', [
    'as'   => 'landing',
    'uses' => 'HomeController@index'
]);
Route::get('/home', [
    'as'   => 'home',
    'uses' => 'HomeController@getHome'
]);
Route::get('/doctrine/{id}',[
    'as'   => 'doctrine',
    'uses' => 'DoctrineController@getDoctrineView'
]);
Route::get('/doctrine/get/{id}',[
    'as'   => 'doctrine',
    'uses' => 'DoctrineController@getDoctrineById'
]);
Route::get('/doctrine/fit/{id}',[
    'as'   => 'doctrine.get',
    'uses' => 'DoctrineController@getFittingById'
]);
Route::get('/join',[
    'as'   => 'join',
    'uses' => 'PageController@getJoin'
]);
Route::get('/auth/eve', [
    'as'   => 'auth.eve',
    'uses' => 'Auth\LoginController@redirectToProvider',
]);
Route::get('/auth/eve/callback', [
    'as'   => 'auth.eve.callback',
    'uses' => 'Auth\LoginController@handleProviderCallback',
]);
Route::get('/pages/{page_name}', [
   'as'    => 'pages',
   'uses'  => 'PageController@getPage'
]);
Route::get('/logout', [
    'as'   => 'logout',
    'uses' => 'Auth\LoginController@logout'
]);
Auth::routes(['register' => false]);

Route::post('/doctrine/{id}/savefitting', [
    'as'   => 'doctrine.saveFitting',
    'uses' => 'DoctrineController@saveFitting',
]);
