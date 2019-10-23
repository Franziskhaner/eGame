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
    @endif
	<div class="panel panel-default">
		<div class="panel-heading">
			<h2>Ratings</h2>
		</div>
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
				@if($ratings->count())
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
				@else
					<tr>
                    	<td colspan="8">There is not register!!</td>
                	</tr>
                @endif
			</tbody>
		</table>
		{{ $ratings->links() }} <!--Con este método, mostramos el paginador en la página de Artículos--> 
        <div class="floating">
            <a href="{{ route('ratings.create') }}" class="btn btn-primary btn-fab">
                <i class="material-icons">add</i> <!-- Añadimos el icono '+' con material design de googleapis.com-->
            </a>
        </div>
	</div>
</div>
@endsection