@extends('layouts.app')
@section('content')
<div class="container">
	@if(session('success'))
        <div class="alert alert-success">
            {{session('success')}}
        </div>
    @elseif(session('delete'))
        <div class="alert alert-success">
            {{session('delete')}}
        </div>
    @elseif(session('error'))
        <div class="custom-alerts alert alert-danger fade in">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
            {{session('error')}}
        </div>
        <?php Session::forget('error');?>
    @endif
	<div class="panel panel-default">
		<div class="panel-heading">
			<div class="row">
                <div class="col-md-8">
                    <h2>Ratings</h2>
                </div>
                <div class="col-md-4">
                    <form action="{{action('MainController@crudSearch', 'ratings')}}" method="get">  
                        <input list="ratings" name="crud_search">
                        <datalist id="ratings">
                            @foreach($ratings as $rating)
                                <option value="{{ $rating->id }}"></option>
                            @endforeach
                        </datalist>
                        <input type="submit" value="Search" class="btn btn-primary">
                    </form>
                </div>  
            </div>
		</div>
		@if($ratings->count())
			<table class="table table-striped">
				<thead style="background-color:#3f51b5; color:white">
					<tr>
						<th>ID</th>
						<th>User ID</th>
						<th>Score</th>
						<th>Comment</th>
						<th>Article ID</th>
						<th>Rating date</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
					@foreach($ratings as $rating)
						<tr>
							<td>{{$rating->id}}</td>
							<td>{{$rating->user_id}}</td>
							<td>{{$rating->score}}</td>
							<td>{{$rating->comment}}</td>
							<td>{{$rating->article_id}}</td>
							<td>{{$rating->created_at}}</td>
							<td>
								<div class="form-group" style="display: inline-block;">
	                        		<a class="btn btn-primary btn-xs" href="{{action('RatingController@edit', $rating->id)}}" >
	                            		<span class="glyphicon glyphicon-pencil"></span>
	                        		</a>
	                                <form action="{{action('RatingController@destroy', $rating->id)}}" method="post">
	                                    {{csrf_field()}}
	                                    <input name="_method" type="hidden" value="DELETE">
	                                    <button class="btn btn-danger btn-xs" type="submit" onclick="return confirm('Are you sure to delete?')">
	                                        <span class="glyphicon glyphicon-trash"></span>
	                                    </button>
	                                </form>
	                    		</div>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		@else
			<tr>
            	<td colspan="8">There is not register!!</td>
        	</tr>
        @endif
		{{ $ratings->links() }} <!--Con este método, mostramos el paginador en la página de Artículos--> 
        <div class="floating">
            <a href="{{ route('ratings.create') }}" class="btn btn-primary btn-fab">
                <i class="material-icons">add</i> <!-- Añadimos el icono '+' con material design de googleapis.com-->
            </a>
        </div>
	</div>
</div>
@endsection