@extends('layouts.app')
@section('content')
<div class="container">
	<div class="row">
		@if(session('success'))
			<div class="alert alert-info">
				{{session('success')}}
			</div>
		@endif
		<div class="panel panel-default">
			<div class="panel-heading">
    			<h1>Your Account</h1>
    		</div>
			<div class="panel-body">
				<div class="row	top-space">
					<div class="col-xs-4 col-md-3 col-lg-2 sale-data text-center"> <!-- Definimos el tamaño por pantalla (movil, mediana y larga) -->
						<span> {{$orders->count()}} </span>
						Shoppings
					</div>

					<div class="col-xs-4 col-md-3 col-lg-2 sale-data">
						<span>{{$ratings->count()}}</span>
						Ratings
					</div>

					<div class="col-xs-4 col-md-3 col-lg-2 sale-data">
						<span>{{sizeof($comments)}}</span>
						Comments
					</div>
				</div>
				<br>
				<h3>Data:</h3>
				<div class="row">
					<div class="col-sm-6 col-xs-12">
						<h4><strong>First name:  </strong>{{$user->first_name}}</h4>
						<h4><strong>Last name:  </strong>{{$user->last_name}}<h4>
						<h4><strong>Email:  </strong>{{$user->email}}<h4>
						<h4><strong>Address:  </strong>{{$user->address}}<h4>
						<h4><strong>City:  </strong>{{$user->city}}<h4>
						<h4><strong>Postal Code:  </strong>{{$user->postal_code}}<h4>
						<h4><strong>Telephone:  </strong>{{$user->telephone}}<h4>
						<h4><strong>Register date:  </strong>{{$user->created_at}}<h4>
					</div>
					<div class="col">
						<div class='form-group'>
							<a class="btn btn-info" href="{{ route('orders') }}">Your Orders</a>
							<a class="btn btn-info" href="{{ route('ratings') }}">Your Ratings</a>
						</div>
						<div class='form-group'>
							<a class="btn btn-primary" href="{{action('UserController@editProfile', $user->id)}}">Edit Profile</a>
							<a class="btn btn-danger" href="{{action('UserController@editProfile', $user->id)}}">Delete Account</a>
						</div>
					</div>	
				</div>
			</div>
		</div>
	</div>
</div>
@endsection