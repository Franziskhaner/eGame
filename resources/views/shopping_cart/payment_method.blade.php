@extends('layouts.app')
@section('content')
	<div class="container">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h2>Select a payment method</h2>
			</div>
			<div class="panel-body">
				<div class="container">
				    <div class="row">
				        <div class="col-md-8 col-md-offset-2">
				            <div class="panel panel-default">
				                @if ($message = Session::get('success'))
				                <div class="custom-alerts alert alert-success fade in">
				                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
				                    {!! $message !!}
				                </div>
				                <?php Session::forget('success');?>
				                @endif
				                @if ($message = Session::get('error'))
				                <div class="custom-alerts alert alert-danger fade in">
				                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
				                    {!! $message !!}
				                </div>
				                <?php Session::forget('error');?>
				                @endif
				                <div class="panel-heading">Pay with Credit Card</div>
				                <div class="panel-body">
				                    <form class="form-horizontal" method="POST" id="payment-form" role="form" action="{!! URL::route('stripform') !!}" >
				                        {{ csrf_field() }}
				                        <div class="form-group{{ $errors->has('card_no') ? ' has-error' : '' }}">
				                            <label for="card_no" class="col-md-4 control-label">Card Number</label>
				                            <div class="col-md-4">
				                                <input id="card_no" type="text" class="form-control" name="card_no" value="{{ old('card_no') }}" autofocus>
				                                @if ($errors->has('card_no'))
				                                    <span class="help-block">
				                                        <strong>{{ $errors->first('card_no') }}</strong>
				                                    </span>
				                                @endif
				                            </div>
				                        </div>
				                        <div class="form-group{{ $errors->has('ccExpiryMonth') ? ' has-error' : '' }}">
				                            <label for="ccExpiryMonth" class="col-md-4 control-label">Expiry Month</label>
				                            <div class="col-md-4">
				                                <input id="ccExpiryMonth" type="text" class="form-control" name="ccExpiryMonth" value="{{ old('ccExpiryMonth') }}" autofocus>
				                                @if ($errors->has('ccExpiryMonth'))
				                                    <span class="help-block">
				                                        <strong>{{ $errors->first('ccExpiryMonth') }}</strong>
				                                    </span>
				                                @endif
				                            </div>
				                        </div>
				                        <div class="form-group{{ $errors->has('ccExpiryYear') ? ' has-error' : '' }}">
				                            <label for="ccExpiryYear" class="col-md-4 control-label">Expiry Year</label>
				                            <div class="col-md-4">
				                                <input id="ccExpiryYear" type="text" class="form-control" name="ccExpiryYear" value="{{ old('ccExpiryYear') }}" autofocus>
				                                @if ($errors->has('ccExpiryYear'))
				                                    <span class="help-block">
				                                        <strong>{{ $errors->first('ccExpiryYear') }}</strong>
				                                    </span>
				                                @endif
				                            </div>
				                        </div>
				                        <div class="form-group{{ $errors->has('cvvNumber') ? ' has-error' : '' }}">
				                            <label for="cvvNumber" class="col-md-4 control-label">CVV Number</label>
				                            <div class="col-md-4">
				                                <input id="cvvNumber" type="text" class="form-control" name="cvvNumber" value="{{ old('cvvNumber') }}" autofocus>
				                                @if ($errors->has('cvvNumber'))
				                                    <span class="help-block">
				                                        <strong>{{ $errors->first('cvvNumber') }}</strong>
				                                    </span>
				                                @endif
				                            </div>
				                        </div>
				                        {{ Form::hidden('amount', $order->total) }}
				                        <div class="form-group">
				                            <div class="col-md-6 col-md-offset-4">
				                                <script  class="stripe-button">
				                                    Paywith Stripe
				                                </script>
				                            </div>
				                        </div>
				                    </form>
				                </div>
				            </div>
				        </div>
				    </div>
				</div>
				<div class="text-center">
					<h1>OR</h1>
				</div>
				<div class="panel-body text-center">
					{!! Form::open(['url' => '/cart', 'method' => 'POST', 'class' => 'inline-block']) !!}
					    <input type="submit" value="Pay with PayPal" class="btn btn-success">
					{!! Form::close() !!}
				</div>
				<div class="text-right">
					<form action="{{ action('OrderController@cancelOrder', $order->id) }}" method="post">
	            		{{csrf_field()}}
	              		<input type="submit" value="Cancel Order" class="btn btn-danger">
	          		</form>
				</div>
			</div>
		</div>
	</div>
@endsection