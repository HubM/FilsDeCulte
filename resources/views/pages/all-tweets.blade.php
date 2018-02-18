<!-- Stored in resources/views/pages/all-tweets.blade.php -->
@extends('layout.base')

@section('content')
  <section class="all-tweets">
    <h1>Nos derniers tweets</h1>

    <div class="tweets">
      @foreach ($tweets as $tweet)
        <div class="tweet-account">
          <img src="{{ $tweet['user_profile'] }}" alt="test">
          <h2>compte : {{ $tweet['user'] }}</h2>
          <p>film : {{ $tweet['movie'] }}</p>
        </div>
      @endforeach
    </div>

  </section>
@endsection