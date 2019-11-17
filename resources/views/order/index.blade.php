@extends('layouts.app')
@section('content')
<div class="container">
	@if(session('success'))
        <div class="alert alert-success">
            {{session('success')}}
        </div>
    @elseif(session('delete'))
        <div class="alert alert-success">
            {{session('delete')}}
        </div>
    @endif
	<div class="panel panel-default">
		<div class="panel-heading">
			<h2>Orders</h2>
		</div>
		<div class="panel-body">
			<h3>Statistics</h3>
			<div class="row top-space">
				<div class="col-md-3 sale-data"> <!-- Definimos el tamaño por pantalla (movil, mediana y larga) -->
					<span>{{$totalIncomes}} €</span>
					Total incomes
				</div>
				<div class="col-md-3 sale-data">
					<span>{{$totalMonth}} €</span>
					Month incomes
				</div>
				<div class="col-md-3 sale-data">
					<span>{{$totalCount}}</span>
					Total sales
				</div>
				<div class="col-md-3 sale-data-2">
					<span>{{$totalMonthCount}}</span>
					Month sales
				</div>
			</div>
			<h3>Shoppings</h3>	
		</div>
		<table class="table table-striped">
			<thead style="background-color:#3f51b5; color:white">
				<tr>
					<th>ID</th>
					<th>Shopping Date</th>
					<th>User ID (Customer)</th>
					<th>Delivery Addressee (Only PayPal)</th>
					<th>Delivery Address</th>
					<th>City</th>
					<th>Postal code</th>
					<th>Province</th>
					<th>Country Code</th>
					<th>Payment Method</th>
					<th>PayPal Account</th>
					<th>Total Amount</th>
					<th>Status</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				@if($orders->count())
					@foreach($orders as $order)
						<tr>
							<td>{{$order->id}}</td>
							<td>{{$order->created_at}}</td>
							<td>{{$order->user_id}}</td>
							<td>{{$order->recipient_name}}</td>
							<td>{{$order->address()}}</td>
							<td>{{$order->city}}</td>
							<td>{{$order->postal_code}}</td>
							<td>{{$order->state}}</td>
							<td>{{$order->country_code}}</td>
							<td>{{$order->payment_method}}</td>
							<td>{{$order->email}}</td>
							<td>{{$order->total}}</td>
							<td>{{$order->status}}</td>
							<td>
								<div class="form-group" style="display: inline-block;">
                            		<a class="btn btn-primary btn-xs" href="{{action('OrderController@edit', $order->id)}}" >
                                		<span class="glyphicon glyphicon-pencil"></span>
                            		</a>
	                                <form action="{{action('OrderController@destroy', $order->id)}}" method="post">
	                                    {{csrf_field()}}
	                                    <input name="_method" type="hidden" value="DELETE">
	                                    <button class="btn btn-danger btn-xs" type="submit" onclick="return confirm('Are you sure to delete?')">
	                                        <span class="glyphicon glyphicon-trash"></span>
	                                    </button>
	                                </form>
                        		</div>
							</td>
						</tr>
					@endforeach
				@else
					<tr>
                    	<td colspan="8">There is not register!!</td>
                	</tr>
                @endif
			</tbody>
		</table>
		{{ $orders->links() }} <!--Con este método, mostramos el paginador en la página de Artículos--> 
        <div class="floating">
            <a href="{{ route('orders.create') }}" class="btn btn-primary btn-fab">
                <i class="material-icons">add</i> <!-- Añadimos el icono '+' con material design de googleapis.com-->
            </a>
        </div>
	</div>
</div>
@endsection