@extends('layouts.app')
@section('content')
<div class="container">
	<div class="row">
		@if(session('success'))
			<div class="alert alert-success">
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
							<a class="btn btn-info" href="{{ route('user_ratings') }}" style="background-color:Orange">Your Ratings</a>
							<a class="btn btn-info" href="{{ route('user_orders') }} " >Your Orders</a>
						
							<a class="btn btn-primary" href="{{action('UserController@editProfile', $user->id)}}">Edit Profile</a>
						</div>
						<form action="{{action('UserController@destroy', $user->id)}}" method="post">
		                   {{csrf_field()}}
		                   <input name="_method" type="hidden" value="DELETE">
		                   <button class="btn btn-danger" type="submit" onclick="return confirm('DANGER! You will delete your account completely, this action cannot be undone, are you sure about this?')">DELETE ACCOUNT</button>
		                </form>
					</div>	
				</div>
			</div>
		</div>
	</div>
</div>
@endsection