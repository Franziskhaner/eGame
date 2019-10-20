@extends('layouts.app')
@section('content')
<div class="container">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h2>Your Ratings</h2>
		</div>
		<div class="panel-body">
			<div class="row top-space">
				<div class="col-xs-4 col-md-3 col-lg-2 sale-data"> <!-- Definimos el tamaño por pantalla (movil, mediana y larga) -->
					<span>{{ $ratings->count() }}</span>
					Total Ratings
				</div>
			</div>
			<br>
			<table class="table table-bordered table-striped">
				<thead style="background-color:#3f51b5; color:white">
					<tr>
						<th>Score</th>
						<th>Article ID</th>
						<th>Comment</th>
						<th>Rating date</th>
					</tr>
				</thead>
				<tbody>
					@foreach($ratings as $rating)
						<tr>
							<td>{{$rating->score}}</td>
 							<td>{{$rating->article_id}}</td>
							<td>{{$rating->comment}}</td>
							<td>{{$rating->created_at}}</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>	
	</div>
</div>

@endsection