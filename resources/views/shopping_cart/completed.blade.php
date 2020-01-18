@extends('layouts.app')
@section('content')
	<div class ="container">
		<div class="panel panel-default">
			<header class="big-padding text-center blue-grey white-text">
				<h1>Shopping Completed</h1>
			</header>
			<div class="panel-body" style="margin-right: 40px; margin-left: 40px; margin-bottom: 40px;">	
				<h2>Your payment was procesed successfully!</h2>
				
				<h3>This is your order number:
					<span class="{{$order->custom_id}}">{{$order->custom_id}}</span>
				</h3>
				<br>
				<p>Please, confirm the details of your shipment:</p>
				<div class="row" style="margin-left: 210px;">
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
				</div>
				<div class="text-center top-space">
					<a href="{{url('/shopping/'.$order->custom_id)}}">Permanent link of your shopping</a>
					<br>
					@if($order->payment_method == 'Credit Card')
						<a href="{{url('https://dashboard.stripe.com/test/payments?status%5B%5D=successful')}}">More information about your payment...</a>
					@else
						<a href="{{url('https://developer.paypal.com/developer/notifications/')}}">More information about your payment...</a>
					@endif
				</div>
			</div>
		</div>
	</div>
@endsection