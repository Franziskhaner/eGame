@extends('layouts.app')
@section('content')
<div class="container">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h2>Rate your purchased games</h2>
		</div>
		<div class="panel-body">
			<div class="text-center">
				<h1>{{$article->name}}</h1>
			<br/>
			</div>
			<div class="row">
				<div class="col-sm-1"></div>
				<div class="col-sm-5">
					@if($article->extension)
						<img src='{{url("/articles/images/$article->id.$article->extension")}}' class="product-avatar">
					@endif
				</div>
				<div class="col-sm-1"></div>
				<div class="col-sm-5">
					<strong>Price:</strong><p>{{$article->price}}</p>
					<strong>Platform:</strong><p>{{$article->platform}}</p>
					<strong>Gender:</strong><p>{{$article->gender}}</p>
					<strong>Release Date:</strong><p>{{$article->release_date}}</p>
					<strong>Players Number:</strong><p>{{$article->players_num}}</p>
					<h3>General Assessment:</h3>
					<br/>
					{!! Form::open(['url' => '/ratings', 'method' => 'POST']) !!}
						{{ csrf_field() }}  
						<div class="form-group">
							{{--<input id="input-1" name="input-1" class="rating rating-loading" data-min="0" data-max="5" data-step="1" value="5" data-size="xs" disabled="">--}}<!-- Esto es para listar los ratings-->
		                    <input id="input-1" name="score" class="rating rating-loading" data-min="0" data-max="5" data-step="1" value="{{ $rating->score }}" data-size="md">
		                    <input id="val" name="rating" value='{{ $rating->score }}' type="hidden" >
		                    <br/>
						</div>
						<h3>Write your opinion:</h3>
						<div class="form-group">		
							{{ Form::text('comment', $rating->comment, ['class' => 'form-control', 'placeholder' => 'Why did you choose this game? What did you like and what not?']) }}
						</div>
						{{ Form::hidden('article_id', $article->id) }}
						<div class="form-group text-center">
							<input type="submit" value="Rate" class="btn btn-success">
							<a href="{{url()->previous()}}" class="btn btn-info">Back</a>
						</div>
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
</div>
@endsection