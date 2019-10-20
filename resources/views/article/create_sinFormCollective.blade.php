@extends('layouts.app')
@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">New article</h3>
				</div>

				<div class="panel-body">					
					<form class="form-horizontal" method="POST" action="{{ route('articles.index') }}" role="form">
						{{ csrf_field() }}
						
						<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
							<div class="col-md-6">
								<input type="text" name="name" class="form-control input-sm" placeholder="Name of the article" value="{{ old('name') }}">

								@if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
							</div>	
						</div>				
						
						<div class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">
							<div class="col-md-6">
								<input type="number" name="price" class="form-control input-sm" placeholder="Price in euros" value="{{ old('price') }}">

								@if ($errors->has('price'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('price') }}</strong>
                                    </span>
	                            @endif
							</div>
						</div>					
					
						<div class="form-group{{ $errors->has('quantity') ? ' has-error' : '' }}">
							<div class="col-md-6">
								<input type="number" name="quantity" class="form-control input-sm" placeholder="Quantity" value="{{ old('quantity') }}">

								@if ($errors->has('quantity'))
	                                <span class="help-block">
	                                    <strong>{{ $errors->first('quantity') }}</strong>
	                                </span>
	                            @endif
							</div>
						</div>
									
						<div class="form-group{{ $errors->has('release_date') ? ' has-error' : '' }}">						
							<div class="col-md-6">
								<input type="date" name="release_date" class="form-control input-sm" placeholder="" value="{{ old('release_date') }}">

								@if ($errors->has('release_date'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('release_date') }}</strong>
                                    </span>
	                            @endif
							</div>
						</div>
						
						<div class="form-group{{ $errors->has('players_num') ? ' has-error' : '' }}">
							<div class="col-md-6">
								<input type="number" name="players_num" class="form-control input-sm" placeholder="Number of players of the game" value="{{ old('players_num') }}">

								@if ($errors->has('players_num'))
	                                <span class="help-block">
	                                    <strong>{{ $errors->first('players_num') }}</strong>
	                                </span>
	                            @endif
							</div>
						</div>	
						<div class="form-group{{ $errors->has('gender') ? ' has-error' : '' }}">
							<div class="col-md-6">
								<input type="text" name="gender" class="form-control input-sm" placeholder="Gender of the game" value="{{ old('gender') }}">

								@if ($errors->has('gender'))
	                                <span class="help-block">
	                                    <strong>{{ $errors->first('gender') }}</strong>
	                                </span>
	                            @endif
							</div>
						</div>
						
						<div class="form-group{{ $errors->has('platform') ? ' has-error' : '' }}">	
							<div class="col-md-6">
								<input type="text" name="platform" class="form-control input-sm" placeholder="Platform" value="{{ old('platform') }}">

								@if ($errors->has('platform'))
	                                <span class="help-block">
	                                    <strong>{{ $errors->first('platform') }}</strong>
	                                </span>
	                            @endif
							</div>		
						</div>			
					
						<div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
							<div class="col-md-6">
								<textarea rows="4" name="description" class="form-control" cols="50" maxlength="250" placeholder="Description">{{ old('description') }}</textarea>

								@if ($errors->has('description'))
	                                <span class="help-block">
	                                    <strong>{{ $errors->first('description') }}</strong>
	                                </span>
	                            @endif
							</div>
						</div>
					
						<div class="form-group{{ $errors->has('assessment') ? ' has-error' : '' }}">
							<div class="col-md-6">
								<input type="number" name="assessment" class="form-control input-sm" placeholder="assessment" maxlength="5" value="{{ old('assessment') }}">

								@if ($errors->has('assessment'))
	                                <span class="help-block">
	                                    <strong>{{ $errors->first('assessment') }}</strong>
	                                </span>
	                            @endif
							</div>
						</div>

						<div class="form-group{{ $errors->has('type') ? ' has-error' : '' }}">
							<div class="col-md-6">
								<select name="type" class="form-control input-sm" placeholder="Type of article">
								  <option value="accesory">Accesory</option>
								  <option value="videoconsole">Videoconsole</option>
								  <option value="videogame">Videogame</option>
								</select>

								@if ($errors->has('type'))
	                                <span class="help-block">
	                                    <strong>{{ $errors->first('type') }}</strong>
	                                </span>
	                            @endif
							</div>
						</div>

						<input type="submit"  value="Save" class="btn btn-success">
						<a href="{{ route('articles.index') }}" class="btn btn-info" >Back</a>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection