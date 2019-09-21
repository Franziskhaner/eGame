@extends('layouts.app')
@section('content')
	<div class="container">	
		@if (count($errors) > 0)
		<div class="alert alert-danger">
			<strong>Error!</strong> Review the required fields.<br><br>
			<ul>
				@foreach ($errors->all() as $error)
				<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
		@endif
		@if(Session::has('success'))
		<div class="alert alert-info">
			{{Session::get('success')}}
		</div>
		@endif
		<div class="row">
        	<div class="col-md-6 col-md-offset-3">
            	<div class="panel panel-default">
            		<div class="panel-heading">
            			<h1>New user</h1>
            		</div>
					<div class="panel-body">
						{{--
						<!-- Formulario -->
						<!-- Con @include llamamos a la plantilla formulario que tenemos en la vista user.form -->
						 --}}
						@include('user.form', ['user' => $user, 'url' => '/users', 'method' => 'POST'])
					</div>
				</div>
			</div>
		</div>
	</div>	
@endsection