@extends('layout.base')
@section('body-class')login @endsection
@section('content')
<div class="container">
  <section>
    <h1 class="text-center">Login</h1>
    <form method="POST" action="{{ route('login') }}">
      @csrf
      <div class="form-group row">

        <div class="col-md-6 offset-md-3">
          <input id="email" type="email" placeholder="Your email..." class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

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
          <div class="checkbox">
            <label>
              <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
            </label>
          </div>
        </div>
      </div>

      <div class="form-group row mb-0">
        <div class="col-md-6 offset-md-3">
          <button type="submit" class="btn btn-primary">
            Login
          </button>

          <a class="btn btn-link d-block" href="{{ route('password.request') }}">
            Forgot Your Password?
          </a>
        </div>
      </div>
    </form>
  </section>
</div>
@endsection
