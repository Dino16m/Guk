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

Route::get('/', 'WelcomeController@index');

Route::get('home', 'HomeController@index');
Route::get('signup', function(){
  return view('signUp');
});
Route::post('signUpcontroller','signUpcontroller@index');
Route::post('dashboard',['as'=>'dashboard','middleware'=>'auth', 'uses'=> 'dashBoardController@index']);
Route::get('dashboard',['as'=>'dashboard','middleware'=>'auth', 'uses'=> 'dashBoardController@index']);
Route::get('test', 'testController@index');
Route::post('login','loginController@login');
Route::get('updateBio',['as'=>'updateBio', ' middleware'=>'auth', 'uses'=>'dashBoardController@updateBioIndex']);
Route::post('updateBio',['as'=>'updateBio', ' middleware'=>'auth', 'uses'=>'dashBoardController@updateBio']);
Route::get('login', ['as'=>'login','uses'=> 'loginController@index']);
Route::get('logout','loginController@logout');
Route::post('logout','loginController@logout');

/**Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);**/
