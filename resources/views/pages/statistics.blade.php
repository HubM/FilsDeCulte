@extends('layout.base')
@section('body-class')stats @endsection
@section('content')
	<section class="container">
		@include('layout.logged-access')
		<header>
			<a href="./about">
				<img src="./images/logo_fdc.svg" alt="Logo fils de culte" class="logo">
			</a>	
			<h1>Stats</h1>
		</header>
		<main>
			@if ($datas)
				<ul class="row stats-list">
					@if ($datas['all_tweets'] > 0)
						<li class="col-md-6 col-lg-4 tweets">
							<img src="./images/tweets.png" alt="Tweets flat icon">
							<h2>{{ $datas['all_tweets'] }}</h2>							
							<p>Tweets made since the beginning :D ! Among them,  <span>{{ $datas['counter_tweets_spoiled'] }}</span> have <span>spoiled</span> their target and <span>{{ $datas['counter_tweets_failed'] }}</span> have <span>failed</span> !<p>
						</li>
					@endif
					@if (!empty($datas['best_spoiler']))
						<li class="col-md-6 col-lg-4 best-spoiler">
							<img src="./images/trophy.png" alt="Trophy flat icon">
							<h2>{{ $datas['best_spoiler'] }}</h2>	
							<p>is the best spoiler, congratulations ! :D</p>
						</li>
					@endif
					@if (!empty($datas['best_movie']))
						<li class="col-md-6 col-lg-4">
							<img src="./images/movie.png" alt="Movie flat icon">
							<h2>{{ $datas['best_movie'] }}</h2>	
							<p>is the best spoiled movie, go watch it ! :D</p>
						</li>					
					@endif 
				</ul>
			@endif 
		</main>
	</section>
@endsection