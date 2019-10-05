@extends('layouts.app')
@section('content')
	<div class="container">	
		<div class="row">
        	<div class="col-md-6 col-md-offset-3">
            	<div class="panel panel-default">
            		<div class="panel-heading">
            			<h1>Edit your profile</h1>
            		</div>
					<div class="panel-body">
						@include('user.form', ['user' => $user, 'url' => '/users/'.$user->id, 'method' => 'PATCH'])
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection