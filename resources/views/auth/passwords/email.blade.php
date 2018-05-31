@extends('layout.base')
@section('body-class')reset-password @endsection
@section('content')
<div class="container">
  <section>
    <h1 class="text-center">Reset</h1>
    <form method="POST" action="{{ route('password.email') }}">
      @csrf

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

      <div class="form-group row mb-0">
        <div class="col-md-6 offset-md-3">
          <button type="submit" class="btn btn-primary">
            Send password
          </button>
        </div>
      </div>
    </form>
  </section>
</div>
@endsection
