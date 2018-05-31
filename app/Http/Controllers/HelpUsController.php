<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class HelpUsController extends Controller
{
  /*
    This function get the post request from the form (/help-us)
    and verify that's the input value aren't null.
    If everything is right, we push the new spoil to our table users_spoil.
    We return the page w/ a success or error message. 
  */
  public function getHelpSpoil(Request $request) {

  	$user = $request->input('user');
  	$movie = $request->input('movie');
  	$spoil = $request->input('spoil');

  	if($user !== null && $movie !== null && $spoil !== null) {
  		DB::table('users_spoil')->insert([
  			'username' => $user,
  			'movie' => $movie,
  			'spoil' => $spoil
  		]);
  	}

		return view('pages.help-us')->with([
			'message' => true,
			'errors' => [
				'user' => $user,
				'movie' => $movie,
				'spoil' => $spoil
			]
		]);	
  }
}
