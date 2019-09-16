@extends('layouts.app')
@section('content')
	<div class="container white">	
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
		<h1>Edit user</h1>
		{{-- <!-- Formulario -->
		<!-- Con @include llamamos a la plantilla formulario que tenemos en la vista user.form --> --}}
		@include('user.form', ['user' => $user, 'url' => '/users/'.$user->id, 'method' => 'PATCH'])
	</div>
@endsection