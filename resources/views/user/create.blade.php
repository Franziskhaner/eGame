@extends('layouts.app')
@section('content')
	<div class="container">	
		{{-- @if (count($errors) > 0)
		<div class="alert alert-danger">
			<strong>Error!</strong> Review the required fields.<br><br>
			<ul>
				@foreach ($errors->all() as $error)
				<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
		@endif --}}
		<div class="row">
        	<div class="col-md-8 col-md-offset-2">
            	<div class="panel panel-default">
            		<div class="panel-heading">
            			<h2>New user</h2>
            		</div>
					<div class="panel-body">
						{{-- <!-- Con @include llamamos a la plantilla formulario que tenemos en la vista user.form --> --}}
						@include('user.form', ['user' => $user, 'url' => '/users', 'method' => 'POST'])
					</div>
				</div>
			</div>
		</div>
	</div>	
@endsection