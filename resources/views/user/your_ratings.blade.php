@extends('layouts.app')
@section('content')
<div class="container">
	@if(session('success'))
        <div class="alert alert-success">
            {{session('success')}}
        </div>
    @endif
	<div class="panel panel-default">
		<div class="panel-heading">
			<h2>Your Ratings</h2>
		</div>
		<div class="panel-body">
			<div class="row top-space">
				<div class="col-md-2 sale-data-2"> <!-- Definimos el tamaño por pantalla (movil, mediana y larga) -->
					<span>{{ $ratings->count() }}</span>
					Total Ratings
				</div>
			</div>
			<br>
			@if($ratings->count())
				<table class="table table-bordered table-striped">
					<thead style="background-color:#3f51b5; color:white">
						<tr>
							<th>Score</th>
							<th>Game</th>
							<th>Comments</th>
							<th>Rating Date</th>
						</tr>
					</thead>
					<tbody>
						@foreach($ratings as $rating)
							<tr>
								<td>
									<!--{{ $starScore = $rating->score }}-->
							        <div class="placeholder" style="color: lightgray;">
							            <i class="fa fa-star"></i>
							            <i class="fa fa-star"></i>
							            <i class="fa fa-star"></i>
							            <i class="fa fa-star"></i>
							            <i class="fa fa-star"></i>
							            <span class="small">({{ $starScore }})</span>
							        </div>
							        <div class="overlay" style="position: relative;top: -22px;">
							            @while($starScore>0)
							                @if($starScore >0.5)
							                    <i class="fa fa-star checked"></i>
							                @else
							                    <i class="fa fa-star-half checked"></i>
							                @endif
							                <!--{{ $starScore-- }}-->
							            @endwhile
							        </div>
							    </td>
	 							<td>{{$articlesCollection->where('id', $rating->article_id)->first()->name}}</td>
								<td>{{$rating->comment}}</td>
								<td>{{$rating->created_at}}</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			@endif
			<div class='form-group text-center'>
				<a href="{{ route('account') }}" class="btn btn-info" >Back to your Account</a>
			</div>
		</div>	
	</div>
</div>

@endsection