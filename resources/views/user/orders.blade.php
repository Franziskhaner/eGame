@extends('layouts.app')
@section('content')
<div class="container">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h2>Your Orders</h2>
		</div>
		<div class="panel-body">
			<div class="row top-space">
				<div class="col-xs-4 col-md-3 col-lg-2 sale-data"> <!-- Definimos el tamaño por pantalla (movil, mediana y larga) -->
					<span>{{$ordersByUser->count()}}</span>
					Total Orders
				</div>
			</div>
			<br>
			<table class="table table-bordered table-striped">
				<thead style="background-color:#3f51b5; color:white">
					<tr>
						<th>Shopping date</th>
						<th>Address</th>
						<th>City</th>
						<th>Postal code</th>
						<th>Province</th>
						<th>Country code</th>
						<th>PayPal account</th>
						<th>Total price</th>
						<th>Status</th>
						<th>Purchased games</th>
					</tr>
				</thead>
				<tbody>
					@foreach($ordersByUser as $order)
						<tr>
							<td>{{$order->created_at}}</td>
 							<td>{{$order->address()}}</td>
							<td>{{$order->city}}</td>
							<td>{{$order->postal_code}}</td>
							<td>{{$order->state}}</td>
							<td>{{$order->country_code}}</td>
							<td>{{$order->email}}</td>
							<td>{{$order->total}} €</td>
							<td>{{$order->status}}</td>
							<td> 
								<!--{{ $counter = 1 }}-->
								@foreach($orderedArticles->where('order_id', $order->id) as $orderedArticle)
									{{ $counter }})
									{{ $articles->where('id', $orderedArticle->article_id)->first()->name }} / 
									{{ $articles->where('id', $orderedArticle->article_id)->first()->price }} € /
									@if($orderedArticle->quantity == 1)
										1 unit<br>
									@else
										{{ $orderedArticle->quantity}} units<br>
									@endif
									<!--{{ ++$counter }}-->
								@endforeach
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>	
	</div>
</div>

@endsection