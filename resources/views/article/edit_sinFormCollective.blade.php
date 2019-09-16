@extends('layouts.app')
@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			
			@if(Session::has('success'))
			<div class="alert alert-info">
				{{Session::get('success')}}
			</div>
			@endif
 
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Edit article</h3>
				</div>
				<div class="panel-body">					
					<form class="form-horizontal" method="POST" action="{{ route('articles.index', $article->id) }}"  role="form">
						{{ csrf_field() }}
						<input name="_method" type="hidden" value="PATCH">
						<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
							<div class="col-md-6">
							<input type="text" name="name" class="form-control input-sm" placeholder="Name of the article" value="{{$article->name}}">

							@if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
							</div>	
						</div>
						<div class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">
							<div class="col-md-6">
								<input type="number" name="price" class="form-control input-sm" placeholder="Price in euros" value="{{$article->price}}">

								@if ($errors->has('price'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('price') }}</strong>
                                    </span>
	                            @endif
							</div>
						</div>					
						<div class="form-group{{ $errors->has('quantity') ? ' has-error' : '' }}">
							<div class="col-md-6">
								<input type="number" name="quantity" class="form-control input-sm" placeholder="Quantity" value="{{$article->quantity}}">

								@if ($errors->has('quantity'))
	                                <span class="help-block">
	                                    <strong>{{ $errors->first('quantity') }}</strong>
	                                </span>
	                            @endif
							</div>
						</div>			
						<div class="form-group{{ $errors->has('release_date') ? ' has-error' : '' }}">				
							<div class="col-md-6">
								<input type="date" name="release_date" class="form-control input-sm" placeholder="" value="{{ $article->release_date }}">

								@if ($errors->has('release_date'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('release_date') }}</strong>
                                    </span>
	                            @endif
							</div>
						</div>
						<div class="form-group{{ $errors->has('players_num') ? ' has-error' : '' }}">
							<div class="col-md-6">
								<input type="number" name="players_num" class="form-control input-sm" placeholder="Number of players of the game" value="{{ $article->players_num }}">

								@if ($errors->has('players_num'))
	                                <span class="help-block">
	                                    <strong>{{ $errors->first('players_num') }}</strong>
	                                </span>
	                            @endif
							</div>
						</div>
						<div class="form-group{{ $errors->has('gender') ? ' has-error' : '' }}">
							<div class="col-md-6">
								<input type="text" name="gender" class="form-control input-sm" placeholder="Gender of the game" value="{{ $article->gender }}">

								@if ($errors->has('gender'))
	                                <span class="help-block">
	                                    <strong>{{ $errors->first('gender') }}</strong>
	                                </span>
	                            @endif
							</div>
						</div>
						<div class="form-group{{ $errors->has('platform') ? ' has-error' : '' }}">	
							<div class="col-md-6">
								<input type="text" name="platform" class="form-control input-sm" placeholder="Platform" value="{{ $article->platform }}">

								@if ($errors->has('platform'))
	                                <span class="help-block">
	                                    <strong>{{ $errors->first('platform') }}</strong>
	                                </span>
	                            @endif
							</div>		
						</div>			
						<div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
							<div class="col-md-6">
								<textarea rows="4" name="description" class="form-control" cols="50" maxlength="250" placeholder="Description">{{$article->description}}</textarea>

								@if ($errors->has('description'))
	                                <span class="help-block">
	                                    <strong>{{ $errors->first('description') }}</strong>
	                                </span>
	                            @endif
							</div>
						</div>
						<div class="form-group{{ $errors->has('assessment') ? ' has-error' : '' }}">
							<div class="col-md-6">
								<input type="number" name="assessment" class="form-control input-sm" placeholder="assessment" maxvalue="5" value="{{$article->assessment}}">

								@if ($errors->has('assessment'))
	                                <span class="help-block">
	                                    <strong>{{ $errors->first('assessment') }}</strong>
	                                </span>
	                            @endif
							</div>
						</div>
						<div class="form-group{{ $errors->has('type') ? ' has-error' : '' }}">
							<div class="col-md-6">
								<select name="type" class="form-control input-sm" placeholder="Type of article" value="{{$article->type}}">
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
						<input type="submit" value="Update" class="btn btn-success"></input>
	                    {{csrf_field()}}
						<a href="{{ route('articles.index') }}" class="btn btn-info">Back</a>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection