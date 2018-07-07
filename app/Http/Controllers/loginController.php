<?php namespace App\Http\Controllers;


use \App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Registrar;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;



use Illuminate\Http\Request;

class loginController extends Controller {
  /**
   * @return view for the login page
   *
   */
   //I need to set a cookie to identify each login instance
	public function index(){
	  if(auth::check()){
	    echo auth::user()->email;
	    return redirect()->route('dashboard');
	  }
	  else{	return view('login');}
	  
	}
	/**
	 *@param Request
	 * @return view
	 * this method authenticates the user and redirects them to their dashboard
	 */
	public function login(Request $request) {
	  $credentials= $request->only('email','password');
	  if (auth::attempt($credentials)){
	   $request->session()->put('email',$request->input('email'));
	   return redirect()->route('dashboard');
	    }
	  else{
	    return view('login')->with(['errormsg'=>'one or more of the details you input are wrong']);
	      }
	}
	/**
	 *@param Request
	 * @return Redirect
	 * this method logs a user out and deletes all the sessions set for the user
	 */
	public function logout(){
	 if(auth::check()){
	  auth::logout();
	  \Session::flush();
	 }
	  return redirect()->action('loginController@index');
	}

}
