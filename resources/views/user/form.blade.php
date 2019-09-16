<!-- Este form va a ser nuestra plantilla para los formularios-->

{!! Form::open(['url' => $url, 'method' => $method]) !!}			
	{{ csrf_field() }}					
	<div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
		{{ Form::text('first_name', $user->first_name, ['class' => 'form-control', 'placeholder' => 'Firt name...']) }}

		@if ($errors->has('first_name'))
            <span class="help-block">
                <strong>{{ $errors->first('first_name') }}</strong>
            </span>
        @endif
	</div>					
	<div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
		{{ Form::text('last_name', $user->last_name, ['class' => 'form-control', 'placeholder' => 'Last name...']) }}

		@if ($errors->has('last_name'))
            <span class="help-block">
                <strong>{{ $errors->first('last_name') }}</strong>
            </span>
        @endif
	</div>		
	<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
		{{ Form::text('email', $user->email, ['class' => 'form-control', 'placeholder' => 'Email...']) }}

		@if ($errors->has('email'))
            <span class="help-block">
                <strong>{{ $errors->first('email') }}</strong>
            </span>
        @endif
	</div>
	<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
		{{ Form::password('password', ['class' => 'form-control', 'placeholder' => 'Password...']) }}

		@if ($errors->has('password'))
            <span class="help-block">
                <strong>{{ $errors->first('password') }}</strong>
            </span>
        @endif
	</div>
	<div class="form-group">
        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder='Confirm password...'>
    </div>
	<div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
		{{ Form::text('address', $user->address, ['class' => 'form-control', 'placeholder' => 'Address...']) }}

		@if ($errors->has('address'))
            <span class="help-block">
                <strong>{{ $errors->first('address') }}</strong>
            </span>
        @endif
	</div>
	<div class="form-group{{ $errors->has('city') ? ' has-error' : '' }}">	
		{{ Form::text('city', $user->city, ['class' => 'form-control', 'placeholder' => 'City...']) }}

		@if ($errors->has('city'))
            <span class="help-block">
                <strong>{{ $errors->first('city') }}</strong>
            </span>
        @endif	
	</div>
	<div class="form-group{{ $errors->has('postal_code') ? ' has-error' : '' }}">
		{{ Form::number('postal_code', $user->postal_code, ['class' => 'form-control', 'placeholder' => 'Postal code...']) }}

		@if ($errors->has('postal_code'))
            <span class="help-block">
                <strong>{{ $errors->first('postal_code') }}</strong>
            </span>
        @endif
	</div>
	<div class="form-group{{ $errors->has('telephone') ? ' has-error' : '' }}">
		{{ Form::number('telephone', $user->telephone, ['class' => 'form-control', 'placeholder' => 'Telephone...']) }}

		@if ($errors->has('telephone'))
            <span class="help-block">
                <strong>{{ $errors->first('telephone') }}</strong>
            </span>
        @endif
	</div>
	<div class="form-group{{ $errors->has('role') ? ' has-error' : '' }}">
		{{ Form::select('role', ['Admin' => 'Admin', 'User' => 'User'], $user->role, ['class' => 'form-control', 'placeholder' => 'Role of user...']) }}

		@if ($errors->has('role'))
            <span class="help-block">
                <strong>{{ $errors->first('role') }}</strong>
            </span>
        @endif
	</div>
	<div class='form-group text-right'>
		<input type="submit"  value="Save" class="btn btn-success">
		<a href="{{ route('users.index') }}" class="btn btn-info" >Back</a>
	</div>
{!! Form::close() !!}