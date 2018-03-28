<!-- Stored in resources/views/pages/about.blade.php -->
@extends('layout.base')

@section('content')
	<section>
		<header>
			<h1>The worst bot on twitter</h1>
		</header>	
		<main>
			<p>Spoil your friends is one of your favorite hobbies ? We are the bad-friend you need !</p>
			<p>Our bot is the evil incarnate. It's mission ? Spoil everybody !</p>
			<a href="#howtouseit">how to use it</a>
		</main>
	</section>

	<section id="howtouseit">
		<header>
			<h2>How to use it</h2>
			<main>
				<p>Spoil your friend is very simple, you only need to follow this steps :</p>
				<ul>
					<li>Create/connect to your twitter account</li>
					<li>Create a tweet and tag in first the bot (@FilsDeCulte), then your account friend (@MyBestFriend) and add one hashtag which represent the serie or movie you would like to spoil (#gamesofthrones)</li>
					<li>Wait and spoil your friend ;)</li>
				</ul>

				<a href="#howitworks">how it works</a>
			</main>
		</header>
	</section>

	<section id="howitworks">
		<header>
			<h2>How it works</h2>
		</header>
		<main>
			<p>We have build a cron which will call a command every 15 minutes. This command will analayze all the tweets which tag the bot, and make a selection to verify they are correct.</p>
			<p>If the tweet is elligible, we get the spoil form our intelligent databse and return it into a response tweet.</p>
			<p>That's it !</p>

			<ul>
				Technologies : 
				<li><a href="https://laravel.com/" target="_blank">Laravel</a></li>
				<li><a href="https://www.algolia.com/" target="_blank">Algolia</a></li>
			</ul>

			<a href="/our-stats">Our statistics</a>
		</main>
	</section>
@endsection