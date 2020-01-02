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
    			<h2>Your Account</h2>
    		</div>
			<div class="panel-body">
				<div class="row	top-space">
					<div class="col-md-4 sale-data"> <!-- Definimos el tamaño por pantalla (movil, mediana y larga) -->
						<span> {{$totalOrders}} </span>
						Shoppings
					</div>

					<div class="col-md-4 sale-data">
						<span>{{$totalRatings}}</span>
						Ratings
					</div>

					<div class="col-md-4 sale-data-2">
						<span>{{sizeof($comments)}}</span>
						Comments
					</div>
				</div>
				<br>
				<div class="row">
					<div class="col-md-4" style="margin:60px; margin-left: 200px;">
						<h4><strong>First name:  </strong>{{$user->first_name}}</h4>
						<h4><strong>Last name:  </strong>{{$user->last_name}}<h4>
						<h4><strong>Email:  </strong>{{$user->email}}<h4>
						<h4><strong>Address:  </strong>{{$user->address}}<h4>
						<h4><strong>City:  </strong>{{$user->city}}<h4>
						<h4><strong>Postal Code:  </strong>{{$user->postal_code}}<h4>
						<h4><strong>Telephone:  </strong>{{$user->telephone}}<h4>
						<h4><strong>Register date:  </strong>{{$user->created_at}}<h4>
					</div>
					<div class="col-md-4" style="margin-top: 50px">
						<div class='form-group text-center'>
							<div class="row">
								<a class="btn btn-info" href="{{ route('user_ratings') }}" style="background-color:Orange">Your Ratings</a>
							</div>
							<div class="row">
								<a class="btn btn-info" href="{{ route('user_orders') }}" >Your Orders</a>
							</div>
							<div class="row">
								<a class="btn btn-primary" href="{{action('UserController@editProfile', $user->id)}}">Edit Profile</a>
							</div>
							<div class="row">
								<form action="{{action('UserController@destroy', $user->id)}}" method="post" style="text-align:center;">
				                   {{csrf_field()}}
				                   <input name="_method" type="hidden" value="DELETE">
				                   <a class="btn btn-danger" type="submit" onclick="return confirm('DANGER! You will delete your account completely, this action cannot be undone, are you sure about this?')">Delete Account</a>
				                </form>
							</div>	
			            </div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection