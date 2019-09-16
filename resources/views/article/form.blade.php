<!-- Este form va a ser nuestra plantilla para los formularios-->

{!! Form::open(['url' => $url, 'method' => $method, 'files' => true]) !!}			
	{{ csrf_field() }}		
	<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
		{{ Form::text('name', $article->name, ['class' => 'form-control', 'placeholder' => 'Name...']) }}

		@if ($errors->has('name'))
            <span class="help-block">
                <strong>{{ $errors->first('name') }}</strong>
            </span>
        @endif
	</div>				
	<div class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">
		{{ Form::number('price', $article->price, ['class' => 'form-control', 'placeholder' => 'Price in euros...']) }}

		@if ($errors->has('price'))
            <span class="help-block">
                <strong>{{ $errors->first('price') }}</strong>
            </span>
        @endif
	</div>					
	<div class="form-group{{ $errors->has('quantity') ? ' has-error' : '' }}">
		{{ Form::number('quantity', $article->quantity, ['class' => 'form-control', 'placeholder' => 'Quantity...']) }}

		@if ($errors->has('quantity'))
            <span class="help-block">
                <strong>{{ $errors->first('quantity') }}</strong>
            </span>
        @endif
	</div>		
	<div class="form-group{{ $errors->has('release_date') ? ' has-error' : '' }}">
		{{ Form::date('release_date', $article->release_date, ['class' => 'form-control', 'placeholder' => 'Release date...']) }}

		@if ($errors->has('release_date'))
            <span class="help-block">
                <strong>{{ $errors->first('release_date') }}</strong>
            </span>
        @endif
	</div>
	<div class="form-group{{ $errors->has('players_num') ? ' has-error' : '' }}">
		{{ Form::number('players_num', $article->players_num, ['class' => 'form-control', 'placeholder' => 'Players number...']) }}

		@if ($errors->has('players_num'))
            <span class="help-block">
                <strong>{{ $errors->first('players_num') }}</strong>
            </span>
        @endif
	</div>	
	<div class="form-group{{ $errors->has('gender') ? ' has-error' : '' }}">
		{{ Form::select('gender', ['Action' => 'Action', 'Shooter' => 'Shooter', 'Fighting' => 'Fighting', 'Platformer' => 'Platformer', 'Horror' => 'Horror', 'Adventure' => 'Adventure', 'RPG' => 'RPG', 'Sport' => 'Sport', 'Strategy' => 'Strategy', 'Puzzle' => 'Puzzle', 'Racing' => 'Racing', 'Simulator' => 'Simulator', 'Open World' => 'Open World'], $article->gender, ['class' => 'form-control', 'placeholder' => 'Gender...']) }}

		@if ($errors->has('gender'))
            <span class="help-block">
                <strong>{{ $errors->first('gender') }}</strong>
            </span>
        @endif
	</div>
	<div class="form-group{{ $errors->has('platform') ? ' has-error' : '' }}">	
		{{ Form::select('platform', ['PS4' => 'PS4', 'XBOX ONE' => 'XBOX ONE', 'PC' => 'PC', 'NINTENDO SWITCH' => 'NINTENDO SWITCH', 'NINTENDO 3DS' => 'NINTENDO 3DS', 'WII U' => 'WII U', 'PS VITA' => 'PLAYSTATION VITA', 'RETRO' => 'RETRO'], $article->platform, ['class' => 'form-control', 'placeholder' => 'Platform...']) }}

		@if ($errors->has('platform'))
            <span class="help-block">
                <strong>{{ $errors->first('platform') }}</strong>
            </span>
        @endif	
	</div>
	<div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
		{{ Form::textarea('description', $article->description, ['class' => 'form-control', 'placeholder' => 'Describe your article...']) }}

		@if ($errors->has('description'))
            <span class="help-block">
                <strong>{{ $errors->first('description') }}</strong>
            </span>
        @endif
	</div>
	<div class="form-group{{ $errors->has('assessment') ? ' has-error' : '' }}">
		{{ Form::number('assessment', $article->assessment, ['class' => 'form-control', 'placeholder' => 'assessment...']) }}

		@if ($errors->has('assessment'))
            <span class="help-block">
                <strong>{{ $errors->first('assessment') }}</strong>
            </span>
        @endif
	</div>
	<div class="form-group">
		{{Form::file('cover')}}
	</div>
	<div class='form-group text-right'>
		<input type="submit"  value="Save" class="btn btn-success">
		<a href="{{ route('articles.index') }}" class="btn btn-info" >Back</a>
	</div>
{!! Form::close() !!}