@extends('layouts.app')
@section('title', 'Articles eGame')
@section('content')
	@if(session('error'))
        <div class="custom-alerts alert alert-danger fade in">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
            {{session('error')}}
        </div>
        <?php Session::forget('error');?>
    @endif
    {{--
	@if($search)
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3>Results with "{{$search}}"</h3>
				<div class="row">
					<div class="col-md-2">
						<h4>Found: {{count($articles)}}</h4>
					</div>
				</div>
			</div>
		</div>
	@endif
	--}}
	<div class="text-center products-container">
		<div class="row">
			@foreach($articles as $article)
			<div class="card product text-left fixed">
				<h1><a href="{{action('ArticleController@show', $article['id'])}}">{{$article['name']}}</a></h1>
					<div class="row">
						<div class="col-sm-5 col-xs-8">
							@if($article['extension'])
								<a href="{{action('ArticleController@show', $article['id'])}}">
									<img src='{{url("/articles/images/$article[id].$article[extension]")}}' class="product-avatar">
								</a>
							@endif
						</div>
						<div class="col-sm-5 col-xs-8">
							<p>
								<strong>Price:</strong><p>{{$article['price']}}</p>
								<strong>Platform:</strong><p>{{$article['platform']}}</p>
								<strong>Assessment:</strong>
								<p>
									@php $rating = $article['assessment']; @endphp
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
							@if($article['quantity'] > 0)
								@include('in_shopping_cart.in_shopping_cart', compact('article'))
							@else
								<span style="color:red">We are so sorry!, this product is actually out of stock =(</span>
							@endif
						</div>
					</div>
				</div>
			@endforeach
		</div>
		<div>
		{{--$articles->links()--}}
		</div>
	</div>
@endsection