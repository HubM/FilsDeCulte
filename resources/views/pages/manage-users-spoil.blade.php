@extends('layout.base')
@section('body-class')users-spoil @endsection
@section('content')
<section class="container">
	<h1>Users spoils</h1>
	
	{{ Form::open(array('url' => '#')) }}
		<table class="table">
		  <thead>
	  	  <tr>
	    	  <th scope="col">#</th>
	      	<th scope="col">Movie</th>
	      	<th scope="col">Spoil</th>
	      	<th scope="col">Action</th>
	    	</tr>
	  	</thead>
	  	<tbody>
	  		@foreach ($spoils as $spoil)
					<tr>
		      	<th scope="row">{{ $spoil->id }}</th>
		      	<td>{{ $spoil->movie }}</td>
		      	<td>{{ $spoil->spoil }}</td>
		      	<td class="actions">
		      		<div>
		      			<label>Keep</label>
		      			{{ Form::radio('action-spoil-'.$spoil->id, '1', array(
									'required'
		      			)) }}
		      		</div>
			      	<div>
			      		<label>Leave</label>
								{{ Form::radio('action-spoil-'.$spoil->id, '0') }}
		  	    	</div>
		   	    </td>
					</tr>
	  		@endforeach
	  	</tbody>
		</table>
		{{ Form::submit('Save', array(
			'class' => 'btn btn-primary'
		)) }}
	{{ Form::close() }}
</section>
@endsection