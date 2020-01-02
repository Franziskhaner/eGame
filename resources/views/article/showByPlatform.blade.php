@extends('layouts.app')

@section('title', 'Articles eGame')

@section('content')
	<div class="text-center products-container">
		<div class="row">
			@if($articles->count() == 0)
				<div class="card product">
					<span style="font-size:160%;">Sorry!! There are no games available for this platform</span>
				</div>
			@else
				@foreach($articles as $article)
				<div class="card product text-left fixed">
					<h1><a href="{{action('ArticleController@show', $article->id)}}">{{$article->name}}</a></h1>
						<div class="row">
							<div class="col-sm-5 col-xs-8">
								@if($article->extension)
									<a href="{{action('ArticleController@show', $article->id)}}">
										<img src='{{url("/articles/images/$article->id.$article->extension")}}' class="product-avatar">
									</a>
								@endif
							</div>
							<div class="col-sm-5 col-xs-8">
								<p>
									<strong>Price:</strong><p>{{$article->price}}</p>
									<strong>Platform:</strong><p>{{$article->platform}}</p>
									<strong>Assessment:</strong>
									<p>
										@php $rating = $article->assessment; @endphp
										<div class="placeholder" style="color: lightgray;">
								            <i class="fa fa-star"></i>
								            <i class="fa fa-star"></i>
								            <i class="fa fa-star"></i>
								            <i class="fa fa-star"></i>
								            <i class="fa fa-star"></i>
								            <span class="small">({{ $rating }})</span>
								        </div>
								        <div class="overlay" style="position: relative;top: -22px;">
								            @while($rating>0)
								                @if($rating >0.5)
								                    <i class="fa fa-star checked"></i>
								                @else
								                    <i class="fa fa-star-half checked"></i>
								                @endif
								                @php $rating--; @endphp
								            @endwhile
								        </div>
									</p>
								@if($article->quantity > 0)
									@include('in_shopping_cart.in_shopping_cart', ['article' => $article])
								@else
									<span style="color:red">We are so sorry!, this product is actually out of stock =(</span>
								@endif
							</div>
						</div>
					</div>
				@endforeach
			@endif
		</div>
		<div>
			{{$articles->links()}}
		</div>
	</div>
@endsection