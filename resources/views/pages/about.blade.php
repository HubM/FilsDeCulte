@extends('layout.base')
@section('body-class')about @endsection
@section('content')
	
  @if (session('status'))
    <div class="alert alert-success">
      {{ session('status') }}
    </div>
  @endif

	@include('layout.logged-access')

	<section class="intro">
		<header>
			<a href="./about">
				<img src="./images/logo_fdc.svg" alt="Logo fils de culte" class="logo">
			</a>
			<h1>The worst bot on <a href="https://twitter.com/FilsDeCulte" target="_blank">twitter</a> <img src="https://emojipedia-us.s3.amazonaws.com/thumbs/320/twitter/134/reversed-hand-with-middle-finger-extended_1f595.png" alt=""></h1>
		</header>	
		<main>
			<p>Spoil your friends is one of your favorite hobbies ? We are the bad-friend you need !</p>
			<p>Our bot is the evil incarnate. It's mission ? Spoil everybody !</p>
			<a href="/our-stats" class="btn btn-1">Check our statistics</a>
		</main>
	</section>
	

		<div class="row">
			<section class="col-6">
				<header>
					<h2>How to use it</h2>
					<main>
						<p>Spoil your friend is very simple, you only need to follow this steps :</p>
						<ul>
							<li>Create/connect to your twitter account</li>
							<li>Create a tweet and tag in first the bot (@FilsDeCulte), then your account friend (@MyBestFriend) and add one hashtag which represent the serie or movie you would like to spoil (#gamesofthrones)</li>
							<li>Wait and spoil your friend ;)</li>
						</ul>
					</main>
				</header>
			</section>

			<section class="col-6">
				<header>
					<h2>How it works</h2>
				</header>
				<main>
					<p>We have build a cron which will call a command every 15 minutes. This command will analayze all the tweets which tag the bot, and make a selection to verify they are correct.</p>
					<p>If the tweet is elligible, we get the spoil form our intelligent databse and return it into a response tweet.</p>
					<p>That's it !</p>

					<h3>Technologies</h3> 
					<ul>
						<li><a href="https://laravel.com/" target="_blank">Laravel</a></li>
						<li><a href="https://www.algolia.com/" target="_blank">Algolia</a></li>
					</ul>

				</main>
			</section>
			
		</div>
@endsection