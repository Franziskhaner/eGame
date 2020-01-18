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
    @elseif(session('error'))
        <div class="custom-alerts alert alert-danger fade in">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
            {{session('error')}}
        </div>
        <?php Session::forget('error');?>
    @endif
	<div class="panel panel-default">
		<div class="panel-heading">
			<div class="row">
                <div class="col-md-7">
                    <h2>Orders</h2>
                </div>
                <div class="col-md-5">
                    <form action="{{action('MainController@crudSearch', 'orders')}}" method="get"> 
                        <input list="orders" name="crud_search" placeholder="Search an order..." style="padding-top: 5px; padding-bottom: 7px; width: 60%;">
                        <datalist id="orders">
                            @foreach($orders as $order)
                                <option value="{{ $order->id }}"></option>
                            @endforeach
                        </datalist>
                        <input type="submit" value="Search" class="btn btn-primary">
                    </form>
                </div>  
            </div>
		</div>
		@if($orders->count())
			<table class="table table-striped">
				<thead style="background-color:#3f51b5; color:white">
					<tr>
						<th>ID</th>
						<th>Shopping Date</th>
						<th>User ID(Customer)</th>
						<th>Delivery Addressee</th>
						<th>Delivery Address</th>
						<th>City</th>
						<th>Postal code</th>
						<th>Province</th>
						<th>Country Code</th>
						<th>Payment Method</th>
						<th>Email</th>
						<th>Total Amount</th>
						<th>Status</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
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
				</tbody>
			</table>
		@else
			<tr>
            	<td colspan="8">There is not register!!</td>
        	</tr>
        @endif
		{{ $orders->links() }} <!--Con este método, mostramos el paginador en la página de Artículos-->
        <div class="floating">
            <a href="{{ route('orders.create') }}" class="btn btn-primary btn-fab">
                <i class="material-icons">add</i> <!-- Añadimos el icono '+' con material design de googleapis.com-->
            </a>
        </div>
	</div>
</div>
@endsection