@extends('layouts.app')

@section('content')

	<div class ="container">
		<header class="big-padding text-center blue-grey white-text">
			<h1>Shopping Completed</h1>
		</header>
		<div class="card large-padding">
			<h2>Your payment was procesed successfully!</h2>
			
			<h3>This is your Order Number:
				<span class="{{$shopping_cart->custom_id}}">{{$shopping_cart->custom_id}}</span>
			</h3>
			
			<p>Please, Confirm the details of your shipment:</p>

			<div class="row large-padding">
				<label class="col-xs-6">Adressee:</label>
				<div class="col-xs-6">{{ $order->recipient_name }}</div>
			</div>
			<div class="row large-padding">
				<label class="col-xs-6">Email:</label>
				<div class="col-xs-6">{{ $order->email }}</div>
			</div>
			<div class="row large-padding">
				<label class="col-xs-6">Address:</label>
				<div class="col-xs-6">{{ $order->address() }}</div>
			</div>
			<div class="row large-padding">
				<label class="col-xs-6">Postal Code:</label>
				<div class="col-xs-6">{{ $order->postal_code }}</div>
			</div>
			<div class="row large-padding">
				<label class="col-xs-6">City:</label>
				<div class="col-xs-6">{{ $order->city }}</div>
			</div>
			<div class="row large-padding">
				<label class="col-xs-6">State and Country:</label>
				<div class="col-xs-6">{{ "$order->state ($order->country_code)" }}</div>
			</div>
			<div class="text-center top-space">
				<a href="{{url('/shopping/'.$shopping_cart->custom_id)}}">Permanent link of your shopping</a>
				<br>
				@if($order->payment_method == 'Credit Card')
					<a href="{{url('https://dashboard.stripe.com/test/payments?status%5B%5D=successful')}}">More information about your payment...</a>
				@endif
			</div>
		</div>
	</div>

@endsection