@extends('layout.base')
@section('body-class')register @endsection
@section('content')
<div class="container">
  <section>
    <h1 class="text-center">Register</h1>
    <form method="POST" action="{{ route('register') }}">
      @csrf

      <div class="form-group row">

        <div class="col-md-6 offset-md-3">
          <input id="name" type="text" placeholder="Your name..." class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>

          @if ($errors->has('name'))
          <span class="invalid-feedback">
            <strong>{{ $errors->first('name') }}</strong>
          </span>
          @endif
        </div>
      </div>

      <div class="form-group row">

        <div class="col-md-6 offset-md-3">
          <input id="email" type="email" placeholder="Your email adress..." class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

          @if ($errors->has('email'))
          <span class="invalid-feedback">
            <strong>{{ $errors->first('email') }}</strong>
          </span>
          @endif
        </div>
      </div>

      <div class="form-group row">
        <div class="col-md-6 offset-md-3">
          <input id="password" type="password" placeholder="Your password..." class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

          @if ($errors->has('password'))
          <span class="invalid-feedback">
            <strong>{{ $errors->first('password') }}</strong>
          </span>
          @endif
        </div>
      </div>

      <div class="form-group row">
        <div class="col-md-6 offset-md-3">
          <input id="password-confirm" placeholder="Confirm password..." type="password" class="form-control" name="password_confirmation" required>
        </div>
      </div>

      <div class="form-group row mb-0">
        <div class="col-md-6 offset-md-3">
          <button type="submit" class="btn btn-primary">
            Register
          </button>
        </div>
      </div>
    </form>
  </section>
</div>
@endsection
