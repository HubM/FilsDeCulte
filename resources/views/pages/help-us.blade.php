@extends('layout.base')
@section('body-class')help-us @endsection
@section('content')
<div class="container">
	<section>
		<header>

			

			<h1>Help us ?</h1>
			
			@if(!empty($message))
				@if($errors['movie'] == null || $errors['spoil'] == null || $errors['user'] == null)
					<div class="alert alert-danger col-8 offset-2" role="alert">
	  				Oops ! Be sure to add a movie title and a spoil..
	  				<img src="./images/sad-face.png" alt="Go to hell Fils de Culte !">
					</div>
					{{ Form::open(array('url' => '#', 'class' => 'row')) }}
						<div class="col-6 offset-3">
							{{ Form::text('user', null, array(
							'class' => 'form-control',
							'placeholder' => ($errors['user'] == null) ? 'Your username...' : $errors['user'],
						)) }}
							{{ Form::text('movie', null, array(
								'class' => 'form-control',
								'placeholder' => ($errors['movie'] == null) ? 'Your movie...' : $errors['movie'],
								)) }}
							{{ Form::textarea('spoil', null, array(
								'class' => 'form-control',
								'placeholder' =>  ($errors['spoil'] == null) ? 'Your spoil...' : $errors['spoil'],
								)) }} 
							{{ Form::submit('Hell yeah !', array(
								'class' => 'btn btn-primary'
							)) }}
						</div>
					{{ Form::close() }}
				@else
					<div class="alert alert-success col-8 offset-2" role="alert">
  					Thank you ! We will verify your spoil and put it in our diabolical database
  				<img src="./images/devil-face.png" alt="Go to hell Fils de Culte !">
					</div>
  				<a href="/" class="btn btn-primary">Back to website</a>
				@endif 
			@else 
				{{ Form::open(array('url' => '#', 'class' => 'row')) }}
					<div class="col-6 offset-3">
						{{ Form::text('user', null, array(
							'class' => 'form-control',
							'placeholder' =>'Your username...',
						)) }}
						{{ Form::text('movie', null, array(
							'class' => 'form-control',
							'placeholder' => 'Your movie...',
							)) }}
						{{ Form::textarea('spoil', null, array(
							'class' => 'form-control',
							'placeholder' => 'Your spoil...',
							)) }} 
						{{ Form::submit('Hell yeah !', array(
							'class' => 'btn btn-primary'
						)) }}
					</div>
				{{ Form::close() }}
			@endif
		</header>
	</section>
</div>
@endsection