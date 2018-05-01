<!-- Stored in resources/views/pages/about.blade.php -->
@extends('layout.base')
@section('body-class')stats colored @endsection
@section('content')
	<div class="container">
		<section class="stats">
			<header>
				<a href="./">
					<img src="./images/logo_fdc.svg" alt="Logo fils de culte" class="logo">
				</a>
				<h1>Stats</h1>
				<p>In this page, we will present you different statistics we got =)</p>
			</header>
			<main>
				<ul class="infos_cards">
					@if ($datas)
						@if ($datas['all_tweets'] > 0)
							<li class="card">
								<div class="card-body text-center">
									<h2 class="card-title">
										{{ $datas['all_tweets'] }}
									</h2>							
									<h3 class="card-subtitle mb-2 text-muted">Tweets made since the beginning :D</h3>
									<p class="card-text">Among them, <span>{{ $datas['counter_tweets_spoiled'] }}</span> have spoiled the target and <span>{{ $datas['counter_tweets_failed'] }}</span> have failed !</p>
								</div>
							</li>
						@endif
						@if (!empty($datas['best_spoiler']))
							<li  class="card">
								<div class="card-body text-center">
									<h2 class="card-title">
										{{ $datas['best_spoiler'] }}
									</h2>	
									<h3 class="card-title mb-2 text-muted">is the best spoiler, congratulations ! :D</h3>
								</div>						
							</li>
						@endif
						@if (!empty($datas['best_movie']))
							<li  class="card">
								<div class="card-body text-center">
									<h2 class="card-title">
										{{ $datas['best_movie'] }}
									</h2>	
									<h3 class="card-title mb-2 text-muted">is the best spoiled movie, go watch it ! :D</h3>
								</div>						
							</li>					
						@endif 
					@endif 
				</ul>
			</main>
		</section>
	</div>
@endsection