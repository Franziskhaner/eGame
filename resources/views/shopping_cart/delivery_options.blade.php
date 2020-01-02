@extends('layouts.app')
@section('content')
	<div class="container">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h2>Select a delivery address</h2>
			</div>
			<div class="panel-body">
				{!! Form::open(['url' => 'payment_method', 'method' => 'POST', 'class' => 'form-horizontal']) !!}  
				    {{ csrf_field() }}
				    <div class="form-group{{ $errors->has('recipient_name') ? ' has-error' : '' }}">
				        <label for="recipient_name" class="col-md-4 control-label">Full Name</label>
				        <div class="col-md-6">
				            {{ Form::text('recipient_name', $order->recipient_name, ['class' => 'form-control']) }}

				            @if ($errors->has('recipient_name'))
				                <span class="help-block">
				                    <strong>{{ $errors->first('recipient_name') }}</strong>
				                </span>
				            @endif
				        </div>
				    </div>
				    <div class="form-group{{ $errors->has('line1') ? ' has-error' : '' }}">
				        <label for="line1" class="col-md-4 control-label">Address Line 1</label>

				        <div class="col-md-6">
				            {{ Form::text('line1', $order->line1, ['class' => 'form-control']) }}

				            @if ($errors->has('line1'))
				                <span class="help-block">
				                    <strong>{{ $errors->first('line1') }}</strong>
				                </span>
				            @endif
				        </div>
				    </div>
				    <div class="form-group{{ $errors->has('line2') ? ' has-error' : '' }}">
				        <label for="line2" class="col-md-4 control-label">Address Line 2 (optional)</label>
				        <div class="col-md-6">
				            {{ Form::text('line2', $order->line2, ['class' => 'form-control']) }}

				            @if ($errors->has('line2'))
				                <span class="help-block">
				                    <strong>{{ $errors->first('line2') }}</strong>
				                </span>
				            @endif
				        </div>
				    </div>
				    <div class="form-group{{ $errors->has('city') ? ' has-error' : '' }}">
				        <label for="city" class="col-md-4 control-label">City</label>

				        <div class="col-md-6">
				            {{ Form::text('city', $order->city, ['class' => 'form-control']) }}

				            @if ($errors->has('city'))
				                <span class="help-block">
				                    <strong>{{ $errors->first('city') }}</strong>
				                </span>
				            @endif
				        </div>
				    </div>
				    <div class="form-group{{ $errors->has('postal_code') ? ' has-error' : '' }}">
				        <label for="postal_code" class="col-md-4 control-label">Postal Code</label>

				        <div class="col-md-6">
				            {{ Form::number('postal_code', $order->postal_code, ['class' => 'form-control']) }}

				            @if ($errors->has('postal_code'))
				                <span class="help-block">
				                    <strong>{{ $errors->first('postal_code') }}</strong>
				                </span>
				            @endif
				        </div>
				    </div>
				    <div class="form-group{{ $errors->has('state') ? ' has-error' : '' }}">
				        <label for="state" class="col-md-4 control-label">Province</label>

				        <div class="col-md-6">
				            {{ Form::text('state', $order->state, ['class' => 'form-control']) }}

				            @if ($errors->has('state'))
				                <span class="help-block">
				                    <strong>{{ $errors->first('state') }}</strong>
				                </span>
				            @endif
				        </div>
				    </div>
				    <div class="form-group{{ $errors->has('country_code') ? ' has-error' : '' }}">
				        <label for="country_code" class="col-md-4 control-label">Country Code</label>

				        <div class="col-md-6">
				            {{ Form::text('country_code', $order->country_code, ['class' => 'form-control']) }}

				            @if ($errors->has('country_code'))
				                <span class="help-block">
				                    <strong>{{ $errors->first('country_code') }}</strong>
				                </span>
				            @endif
				        </div>
				    </div>
  					<br>
  					<br>
				    <div class="text-center">
						<input type="submit"  value="Continue" class="btn btn-success">
				        <a href="{{route('home')}}" class="btn btn-info">Cancel</a>
					</div>
				{!! Form::close() !!}
			</div>
		</div>
	</div>
@endsection