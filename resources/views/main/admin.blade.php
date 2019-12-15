@extends('layouts.app')
@section('content')
	<div class= "container">
		@if(session('success'))
	        <div class="alert alert-success">
	            {{session('success')}}
	        </div>
	    @elseif(session('delete'))
	        <div class="alert alert-success">
	            {{session('delete')}}
	        </div>
	    @endif
		<div class="big-padding text-center blue-grey white-text">
			<h2>Admin Panel</h2>
		</div>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3>Recommendations System Options</h3>
			</div>
			<div class="panel-body">
				<div class="row" style="display: flex;justify-content: center;align-items: center;">	
					<div class="col-md-6">
						<form action="{{action('MainController@update', $weigths)}}" method="post" class="form-horizontal" style="text-align:center;">
			    			{{ csrf_field() }}
			    			<br>
							<h4>Actual values for the Recommendations System Weights:</h4>
							<br>
							<div class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">
						        <label for="price" class="col-md-6 control-label">Price Weigth:</label>
						        <div class="col-md-3">
						            {{ Form::select('price',[1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5], $weigths->price, ['class' => 'form-control']) }}

						            @if ($errors->has('price'))
						                <span class="help-block">
						                    <strong>{{ $errors->first('price') }}</strong>
						                </span>
						            @endif
						        </div>
						    </div>
						    <div class="form-group{{ $errors->has('gender') ? ' has-error' : '' }}">
						        <label for="gender" class="col-md-6 control-label">Gender Weigth:</label>
						        <div class="col-md-3">
						            {{ Form::select('gender',[1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5], $weigths->gender, ['class' => 'form-control']) }}

						            @if ($errors->has('gender'))
						                <span class="help-block">
						                    <strong>{{ $errors->first('gender') }}</strong>
						                </span>
						            @endif
						        </div>
						    </div>
						    <div class="form-group{{ $errors->has('platform') ? ' has-error' : '' }}">
						        <label for="platform" class="col-md-6 control-label">Platform Weigth:</label>
						        <div class="col-md-3">
						            {{ Form::select('platform',[1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5], $weigths->platform, ['class' => 'form-control']) }}

						            @if ($errors->has('platform'))
						                <span class="help-block">
						                    <strong>{{ $errors->first('platform') }}</strong>
						                </span>
						            @endif
						        </div>
						    </div>
						    <div class="col">
						    	<input type="submit"  value="Change Values" class="btn btn-success">
						    </div>
						</form>
					</div>
					<div class="col" >
						<a class="btn btn-info" href="{{ route('recommendations') }}" style="background-color:Orange">Show Recommendations</a>
					</div>
				</div>
			</div>
			<div class="panel-heading">
				<h3>Dashboard</h3>
			</div>
			<div class="panel-body">
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
			</div>
		</div>
	</div>
@endsection