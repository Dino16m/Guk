<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function(){
    return view('welcome');
});

Route::get('home', 'HomeController@index');
Route::get('signUp',['as'=>'signUp', 'middleware'=>'isAdmin', 'uses'=>'signUpcontroller@index']);
Route::post('signUp',['as'=> 'signUp','middleware'=>'isAdmin','uses' => 'signUpcontroller@signup']);
Route::post('dashboard',['as'=>'dashboard','middleware'=>'auth', 'uses'=> 'dashBoardController@index']);
Route::get('dashboard',['as'=>'dashboard','middleware'=>'auth', 'uses'=> 'dashBoardController@index']);
Route::get('test', 'testController@index');
Route::post('login','loginController@login');
Route::get('updateBio',['as'=>'updateBio', ' middleware'=>'auth', 'uses'=>'dashBoardController@updateBioIndex']);
Route::post('updateBio',['as'=>'updateBio', ' middleware'=>'auth', 'uses'=>'dashBoardController@updateBio']);
Route::get('login', ['as'=>'login','uses'=> 'loginController@index']);
Route::get('logout','loginController@logout');
Route::post('logout','loginController@logout');
Route::get('admin', ['as'=>'admin', 'middleware'=>'isAdmin', 'uses'=>'adminController@index']);
Route::post('admin', ['as'=>'admin', 'middleware'=>'isAdmin', 'uses'=>'adminController@handle']);

/**Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);**/
