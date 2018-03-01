<!-- Stored in resources/views/pages/all-tweets.blade.php -->
@extends('layout.base')

@section('content')
  <section class="all-tweets">
    <h1>Nos derniers tweets</h1>

    <div class="tweets row">
      @foreach ($tweets as $tweet)
        <div class="tweet-account col-6 col-md-4 text-center">
          <img src="{{ $tweet['user_profile'] }}" alt="test" class="center">
          <h2 class="font-weight-bold">{{ $tweet['user'] }}</h2>
          <p>film : <span class="font-weight-bold">{{ $tweet['movie'] }}</span></p>
        </div>
      @endforeach
    </div>

  </section>
@endsection