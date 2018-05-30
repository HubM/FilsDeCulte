<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HelpUsController extends Controller
{
  public function getHelpSpoil(Request $request) {

  	$movie = $request->input('movie');
  	$spoil = $request->input('spoil');

		return view('pages.help-us')->with([
			'message' => true,
			'errors' => [
				'movie' => $movie,
				'spoil' => $spoil
			]
		]);	
  }
}
