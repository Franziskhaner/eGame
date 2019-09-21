@extends('layouts.app')
@section('content')
<div class="container">
	<div class="row">
		<div class="panel panel-default">
			<div class="panel-heading">
    			<h1>{{$user->first_name.' '.$user->last_name}}</h1>
    		</div>
			<div class="panel-body">
			</div>
		</div>
	</div>
</div>
@endsection