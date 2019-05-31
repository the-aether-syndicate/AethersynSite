<?php
/**
 * Created by PhpStorm.
 * User: bitch
 * Date: 5/29/2019
 * Time: 7:31 PM
 */

Route::get('/home',[
    'as'   => 'home',
    'uses' => 'HomeController@getHome'
]);