<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use \App\User;

use Illuminate\Http\Request;

class testController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
	  return redirect()->route('/auth/login');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
}