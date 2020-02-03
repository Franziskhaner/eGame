@extends('layouts.app')
@section('content')
@if(session('error'))
    <div class="custom-alerts alert alert-danger fade in">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
        {{session('error')}}
    </div>
    <?php Session::forget('error');?>
@endif
<div class="container">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h2>Your Orders</h2>
		</div>
		<div class="panel-body">
			<div class="row top-space">
				<div class="col-md-3 sale-data-2"> <!-- Definimos el tamaño por pantalla (movil, mediana y larga) -->
					<span>{{$total}}</span>
					Total Orders
				</div>
				<di class="col-md-3 text-right">	 
				</di>
				<div class="col-md-6">
                    <form action="{{action('UserController@searchYourOrder')}}" method="get">
                        <input name="searchYourOrder" placeholder="Insert your order number..." style="padding-top: 5px; padding-bottom: 7px; width: 60%;">
                        <datalist>
                            @foreach($ordersByUser as $orderByUser)
                                <option value="{{ $orderByUser->id }}"></option>
                            @endforeach
                        </datalist>
                        <input type="submit" value="Search" class="btn btn-primary">
                    </form>
                </div>
			</div>
			<br>
			@if($ordersByUser->count())
				<table class="table table-bordered table-striped">
					<thead style="background-color:#3f51b5; color:white">
						<tr>
							<th>Shopping Date</th>
							<th style="width:5px">Order Number</th>
							<th>Addressee</th>
							<th>Address</th>
							<th>City</th>
							<th>Postal Code</th>
							<th>Province</th>
							<th>Email</th>
							<th>Payment Method</th>
							<th>Total Price</th>
							<th>Purchased Games</th>
							<th>Rate your games!</th>
						</tr>
					</thead>
					<tbody>
						@foreach($ordersByUser as $order)
							<tr>
								<td>{{$order->created_at}}</td>
								<td style="width:5px">{{$order->custom_id}}</td>
								<td>{{$order->recipient_name}}</td>
	 							<td>{{$order->address()}}</td>
								<td>{{$order->city}}</td>
								<td>{{$order->postal_code}}</td>
								<td>{{$order->state}}</td>
								<td>{{$order->email}}</td>
								<td>{{$order->payment_method}}</td>
								<td>{{$order->total}} €</td>
								<td> 
									<!--{{ $counter = 1 }}-->
									@foreach($orderedArticles->where('order_id', $order->id) as $orderedArticle)
										{{ $counter }})
										{{ $articles->where('id', $orderedArticle->article_id)->first()->name }} / 
										{{ $articles->where('id', $orderedArticle->article_id)->first()->gender }} / 
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
									<select name= "selectGameToRate" class="selectedGamesToRate" onclick="myFunction(this, '{{$order->id}}')" style="width: 80px">
										<option value="" selected disabled hidden>Choose</option>
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