@extends('layouts.app')
@section('content')
<div class="container">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h2>Dashboard</h2>
		</div>
		<div class="panel-body">
			<h3>Statistics</h3>
			<div class="row top-space">
				<div class="col-xs-4 col-md-3 col-lg-2 sale-data"> <!-- Definimos el tamaño por pantalla (movil, mediana y larga) -->
					<span>{{$totalMonth}} €</span>
					Month incomes
				</div>

				<div class="col-xs-4 col-md-3 col-lg-2 sale-data">
					<span>{{$totalMonthCount}}</span>
					Sales number
				</div>
			</div>
			<h3>Shoppings</h3>
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>ID</th>
						<th>Customer</th>
						<th>Address</th>
						<th>City</th>
						<th>Postal code</th>
						<th>Province</th>
						<th>Country code</th>
						<th>PayPal account</th>
						<th>Total amount</th>
						<th>Shopping date</th>
						<th>Status</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
					@foreach($orders as $order)
						<tr>
							<td>{{$order->id}}</td>
							<td>{{$order->recipient_name}}</td>
							<td>{{$order->address()}}</td>
							<td>{{$order->city}}</td>
							<td>{{$order->postal_code}}</td>
							<td>{{$order->state}}</td>
							<td>{{$order->country_code}}</td>
							<td>{{$order->email}}</td>
							<td>{{$order->total}}</td>
							<td>{{$order->created_at}}</td>
							<td>{{$order->status}}</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>
@endsection