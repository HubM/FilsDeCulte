@extends('layout.base')
@section('body-class')users-spoil @endsection
@section('content')
<section>
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
		     
		      			<label>
      			 			{{ Form::radio('action-spoil-'.$spoil->id, '1', true) }}
		      				<span>Keep</span>
		      			</label>
		      		</div>
			      	<div>
			      		<label>
								{{ Form::radio('action-spoil-'.$spoil->id, '0') }}
			      			<span>Leave</span>
			      		</label>
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