@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2>Edit Order</h2>
                </div>
                <div class="panel-body">
                    @include('order.form', ['order' => $order, 'url' => '/orders/'.$order->id, 'method' => 'PATCH'])
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
