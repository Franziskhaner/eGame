<!-- Este form va a ser nuestra plantilla para los formularios-->

{!! Form::open(['url' => $url, 'method' => $method, 'class' => 'form-horizontal']) !!}			
	{{ csrf_field() }}

	<div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
		<label for="first_name" class="col-md-4 control-label">First Name</label>
		<div class="col-md-6">
			{{ Form::text('first_name', $user->first_name, ['class' => 'form-control']) }}

			@if ($errors->has('first_name'))
	            <span class="help-block">
	                <strong>{{ $errors->first('first_name') }}</strong>
	            </span>
	        @endif
    	</div>
	</div>	
					
	<div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
		<label for="last_name" class="col-md-4 control-label">Last Name</label>
		<div class="col-md-6">
			{{ Form::text('last_name', $user->last_name, ['class' => 'form-control']) }}

			@if ($errors->has('last_name'))
	            <span class="help-block">
	                <strong>{{ $errors->first('last_name') }}</strong>
	            </span>
	        @endif
	    </div>
	</div>	

	<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
		<label for="email" class="col-md-4 control-label">E-Mail</label>
		<div class="col-md-6">
			{{ Form::email('email', $user->email, ['class' => 'form-control']) }}

			@if ($errors->has('email'))
	            <span class="help-block">
	                <strong>{{ $errors->first('email') }}</strong>
	            </span>
	        @endif
	    </div>
	</div>

	<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
		<label for="password" class="col-md-4 control-label">Password</label>
		<div class="col-md-6">
			{{ Form::password('password', ['class' => 'form-control']) }}

			@if ($errors->has('password'))
	            <span class="help-block">
	                <strong>{{ $errors->first('password') }}</strong>
	            </span>
	        @endif
	    </div>
	</div>
	
	<div class="form-group">
		<label for="password-confirm" class="col-md-4 control-label">Password Confirm</label>
		<div class="col-md-6">
        	<input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder='Confirm password...'>
        </div>
    </div>
    
	<div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
		<label for="address" class="col-md-4 control-label">Address</label>
		<div class="col-md-6">
			{{ Form::text('address', $user->address, ['class' => 'form-control']) }}

			@if ($errors->has('address'))
	            <span class="help-block">
	                <strong>{{ $errors->first('address') }}</strong>
	            </span>
	        @endif
	    </div>
	</div>
	
	<div class="form-group{{ $errors->has('city') ? ' has-error' : '' }}">
		<label for="city" class="col-md-4 control-label">City</label>
		<div class="col-md-6">
			{{ Form::text('city', $user->city, ['class' => 'form-control']) }}

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
			{{ Form::number('postal_code', $user->postal_code, ['class' => 'form-control']) }}

			@if ($errors->has('postal_code'))
	            <span class="help-block">
	                <strong>{{ $errors->first('postal_code') }}</strong>
	            </span>
	        @endif
	    </div>
	</div>
	
	<div class="form-group{{ $errors->has('telephone') ? ' has-error' : '' }}">
		<label for="telephone" class="col-md-4 control-label">Telephone</label>
		<div class="col-md-6">
			{{ Form::number('telephone', $user->telephone, ['class' => 'form-control']) }}

			@if ($errors->has('telephone'))
	            <span class="help-block">
	                <strong>{{ $errors->first('telephone') }}</strong>
	            </span>
	        @endif
	    </div>
	</div>
	
	@if(Auth::user()->role == 'Admin')
		<div class="form-group{{ $errors->has('role') ? ' has-error' : '' }}">
			<label for="role" class="col-md-4 control-label">Role</label>
			<div class="col-md-6">
				{{ Form::select('role', ['Admin' => 'Admin', 'User' => 'User'], $user->role, ['class' => 'form-control', 'placeholder' => 'Role of user...']) }}

				@if ($errors->has('role'))
		            <span class="help-block">
		                <strong>{{ $errors->first('role') }}</strong>
		            </span>
		        @endif
		    </div>
		</div>
	@endif
	
	<div class='form-group text-center'>
		<input type="submit"  value="Save" class="btn btn-success">
		<a href="{{ url()->previous() }}" class="btn btn-info" >Back</a>
	</div>
{!! Form::close() !!}