@extends('layouts.app')
@section('content')
<div class="container">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h2>Your Orders</h2>
		</div>
		<div class="panel-body">
			<div class="row top-space">
				<div class="col-md-2 sale-data-2"> <!-- Definimos el tamaño por pantalla (movil, mediana y larga) -->
					<span>{{$total}}</span>
					Total Orders
				</div>
			</div>
			<br>
			@if($ordersByUser->count())
				<table class="table table-bordered table-striped">
					<thead style="background-color:#3f51b5; color:white">
						<tr>
							<th>Shopping Date</th>
							<th>Address</th>
							<th>City</th>
							<th>Postal Code</th>
							<th>Province</th>
							<th>Country Code</th>
							<th>PayPal Account</th>
							<th>Total Price</th>
							<th>Status</th>
							<th>Purchased Games</th>
							<th>Rate your games!</th>
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
								<td>
									<select class="selectedGamesToRate" onclick="myFunction(this, '{{$order->id}}')">
										<option value="" selected disabled hidden>Choose here</option>
										@foreach($orderedArticles->where('order_id', $order->id) as $orderedArticle)
											<option>
												{{ $articles->where('id', $orderedArticle->article_id)->first()->name }}
											</option>
										@endforeach
									</select>
									<a id="starButton-{{$order->id}}" class="btn btn-primary btn-xs" href="">
										<span class="glyphicon glyphicon-star"></span>
									</a>
	                            </td>
							</tr>
						@endforeach
					</tbody>
				</table>
			@endif
			{{ $ordersByUser->links() }}
			<div class='form-group text-center'>
				<a href="{{ route('account') }}" class="btn btn-info" >Back to your Account</a>
			</div>
		</div>	
	</div>
</div>
@endsection