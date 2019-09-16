@extends('layouts.app')
@section('content')
	<div class= "container">
		<div class="big-padding text-center blue-grey white-text">
			<h2>Your shopping cart</h2>
		</div>
		<table class="table table-bordered">
			<thead>
				<tr>
					<th>Article</th>
					<th>Price</th>
					<th>Quantity</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				@for($i = 0; $i < $articles->count(); $i++)
					<tr>
						<td>{{$articles[$i]->name}}</td>
						<td>{{$articles[$i]->price}}</td>
						<td>{{$in_shopping_carts[$i]->quantity}}</td>
						<input type="hidden" name="total" value="{{$total = $total + $in_shopping_carts[$i]->quantity * $articles[$i]->price}}">
						<td>
							<form action="{{ action('InShoppingCartController@destroy', $in_shopping_carts[$i]->id) }}" method="post">
		                		{{csrf_field()}}
		                  		<input name="_method" type="hidden" value="DELETE">
		                  		<button class="btn btn-danger btn-xs" type="submit"><span class="glyphicon glyphicon-trash"></span></button>
		              		</form>
						</td>
					</tr>
				@endfor
				<tr>
					<th>Total</th>
					<td>{{$total}}</td>
					<td>{{$in_shopping_carts->sum('quantity')}}</td>	<!-- Mostramos la suma de las cantidades de todos los artículos -->
				</tr>
			</tbody>
		</table>
		<div class='text-right'>
			@include('shopping_cart.form')
		</div>
	</div>
@endsection