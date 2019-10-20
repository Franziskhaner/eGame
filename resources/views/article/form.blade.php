<!-- Este form va a ser nuestra plantilla para los formularios-->

{!! Form::open(['url' => $url, 'method' => $method, 'class' => 'form-horizontal', 'files' => true]) !!}			
	{{ csrf_field() }}	

	<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
		<label for="name" class="col-md-4 control-label">Name</label>
		<div class="col-md-6">
			<input id="name" type="text" class="form-control" name="name" value="{{ $article->name }}">

			@if ($errors->has('name'))
	            <span class="help-block">
	                <strong>{{ $errors->first('name') }}</strong>
	            </span>
	        @endif
	    </div>
	</div>

	<div class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">
		<label for="price" class="col-md-4 control-label">Price</label>
		<div class="col-md-6">
			<input id="price" type="number" class="form-control" name="price" value="{{ $article->price }}">

			@if ($errors->has('price'))
	            <span class="help-block">
	                <strong>{{ $errors->first('price') }}</strong>
	            </span>
	        @endif
	    </div>
	</div>
			
	<div class="form-group{{ $errors->has('quantity') ? ' has-error' : '' }}">
		<label for="quantity" class="col-md-4 control-label">Quantity</label>
		<div class="col-md-6">
			<input id="quantity" type="number" class="form-control" name="quantity" value="{{ $article->quantity }}">

			@if ($errors->has('quantity'))
	            <span class="help-block">
	                <strong>{{ $errors->first('quantity') }}</strong>
	            </span>
	        @endif
	    </div>
	</div>
			
	<div class="form-group{{ $errors->has('release_date') ? ' has-error' : '' }}">
		<label for="release_date" class="col-md-4 control-label">Release date</label>
		<div class="col-md-6">
			<input id="quantity" type="date" class="form-control" name="release_date" value="{{ $article->release_date }}">

			@if ($errors->has('release_date'))
	            <span class="help-block">
	                <strong>{{ $errors->first('release_date') }}</strong>
	            </span>
	        @endif
	    </div>
	</div>
	
	<div class="form-group{{ $errors->has('players_num') ? ' has-error' : '' }}">
		<label for="players_num" class="col-md-4 control-label">Players number</label>
		<div class="col-md-6">
			<input id="players_num" type="number" class="form-control" name="players_num" value="{{ $article->players_num }}">

			@if ($errors->has('players_num'))
	            <span class="help-block">
	                <strong>{{ $errors->first('players_num') }}</strong>
	            </span>
	        @endif	
	    </div>
	</div>
	
	<div class="form-group{{ $errors->has('gender') ? ' has-error' : '' }}">
		<label for="gender" class="col-md-4 control-label">Gender</label>
		<div class="col-md-6">
			{{ Form::select('gender', ['Action' => 'Action', 'Shooter' => 'Shooter', 'Fighting' => 'Fighting', 'Platformer' => 'Platformer', 'Horror' => 'Horror', 'Adventure' => 'Adventure', 'RPG' => 'RPG', 'Sport' => 'Sport', 'Strategy' => 'Strategy', 'Puzzle' => 'Puzzle', 'Racing' => 'Racing', 'Simulator' => 'Simulator', 'Open World' => 'Open World'], $article->gender, ['class' => 'form-control']) }}

			@if ($errors->has('gender'))
	            <span class="help-block">
	                <strong>{{ $errors->first('gender') }}</strong>
	            </span>
	        @endif
	    </div>
	</div>

	<div class="form-group{{ $errors->has('platform') ? ' has-error' : '' }}">
		<label for="platform" class="col-md-4 control-label">Platform</label>
		<div class="col-md-6">
			{{ Form::select('platform', ['PS4' => 'PS4', 'XBOX ONE' => 'XBOX ONE', 'PC' => 'PC', 'NINTENDO SWITCH' => 'NINTENDO SWITCH', 'NINTENDO 3DS' => 'NINTENDO 3DS', 'WII U' => 'WII U', 'PS VITA' => 'PLAYSTATION VITA', 'RETRO' => 'RETRO'], $article->platform, ['class' => 'form-control']) }}

			@if ($errors->has('platform'))
	            <span class="help-block">
	                <strong>{{ $errors->first('platform') }}</strong>
	            </span>
	        @endif
	    </div>
	</div>

	<div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
		<label for="description" class="col-md-4 control-label">Description</label>
		<div class="col-md-6">
			{{ Form::textarea('description', $article->description, ['class' => 'form-control', 'placeholder' => 'Describe your article...']) }}

			@if ($errors->has('description'))
	            <span class="help-block">
	                <strong>{{ $errors->first('description') }}</strong>
	            </span>
	        @endif
	    </div>
	</div>

	<div class="form-group{{ $errors->has('assessment') ? ' has-error' : '' }}">
		<label for="assessment" class="col-md-4 control-label">Assessment</label>
		<div class="col-md-6">
			{{ Form::select('assessment',[1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5], $article->assessment, ['class' => 'form-control']) }}

			@if ($errors->has('assessment'))
	            <span class="help-block">
	                <strong>{{ $errors->first('assessment') }}</strong>
	            </span>
	        @endif
	    </div>
	</div>

	<div class="form-group">
		<label for="assessment" class="col-md-4 control-label">Image file</label>
		<div class="col-md-6">
			{{Form::file('cover')}}
		</div>
	</div>

	<div class="form-group">
        <div class="col-md-6 col-md-offset-4">
            <button type="submit" class="btn btn-success">
                Save
            </button>
            <a href="{{ url()->previous() }}" class="btn btn-info" >Back</a>
        </div>
    </div>
{!! Form::close() !!}