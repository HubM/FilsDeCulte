<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use \App\Jobs\addSpoilToAlgoliaCollectionJob;
use Illuminate\Foundation\Bus\DispatchesJobs;

class HelpUsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

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

  /*
    This function simply get all users_spoil tables entries and pushed it in 
    the manage-users-spoil view
  */
  public function getAllUserSpoils() {
  	$all_spoils = DB::table('users_spoil')->get();
  	return view('pages.manage-users-spoil')->with('spoils', $all_spoils);
  }

  /*
    This function interpret the result of the manage-users-spoil form post request.
    For each spoil, we verify if the radio button checked has 1 as value.
    If yes, it means that the admin has accept to keep this spoil, so we 
    execute the addSpoilToAlgoliaCollectionJob job which will make a connection to algolia
    and create a new index with the spoil value.
    We finally render the same page, with the spoils list updated.
  */
  public function saveManagedUsersSpoils(Request $request) {
    $spoils = DB::table('users_spoil');

    foreach ($spoils->get() as $spoil) {
      $spoil_action = intval($request->input('action-spoil-'.$spoil->id));
      
      if($spoil_action === 1) {
        $job = new addSpoilToAlgoliaCollectionJob($spoil);
        $this->dispatch($job);
      }

      $spoil = $spoils->where('id', '=', $spoil->id)->delete();
    }

    return view('pages.manage-users-spoil')->with('spoils', $spoils->get());
  }
}
