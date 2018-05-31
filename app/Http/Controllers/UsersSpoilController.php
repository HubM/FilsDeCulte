<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use \App\Jobs\addSpoilToAlgoliaCollectionJob;
use Illuminate\Foundation\Bus\DispatchesJobs;

class UsersSpoilController extends Controller
{
  
  public function __construct()
  {
    $this->middleware('auth');
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
