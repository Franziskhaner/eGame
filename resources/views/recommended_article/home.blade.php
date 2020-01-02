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
    <div class="container">
	    @include('recommended_article.purchased_based_recommendations', compact('articlesByContentBasedFiltering'))
		@include('recommended_article.collaborative_filtering_based_recommendations', compact('articlesByCollaborativeFiltering'))
		@if(Auth::user()->role != 'Admin')
			<div class="panel">
				<div class="panel-heading">
					<h2>Top Ratings</h2>
				</div>
				<div class="panel-body" style="margin: 20px;">
					<div class="carousel">
						<!-- {{ $count = 1 }}-->
						<ul class="carousel__thumbnails">
							@for($i = 0; $i < sizeof($bestRated); $i++)
								<span>{{$count++}})</span>
				                <li>
				                    <a href="{{action('ArticleController@show', $bestRated[$i]['id'])}}" for="slide-$i">
					                    <img style="height: 180px; width: auto; border-top: 1px solid #ccc; background-color: #f7f7f7" src="{{ url("/articles/images/".$bestRated[$i]['id'].".".$bestRated[$i]['extension']) }}" alt="">
				                    </a>
				                    <div class="card-body">
				                        <h5 class="card-title">{{ $bestRated[$i]['name'] }}</h5>
				                        <p class="card-text text-muted">({{ $bestRated[$i]['gender'] }} - {{ $bestRated[$i]['price'] }} €)</p>
				                        <p>
											@php $rating = $bestRated[$i]['assessment'] @endphp
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
				                        {!! Form::open(['url' => '/in_shopping_carts', 'method' => 'POST', 'class' => 'inline-block']) !!}
											<input type="hidden" name="article_id" value="{{$bestRated[$i]['id']}}">
											<button type="submit" class="btn btn-info" style="position: relative;top: -22px;">
												<span class= "glyphicon glyphicon-shopping-cart"></span>
											</button>
										{!! Form::close() !!}  
				                    </div>
				                </li>
				    		@endfor
				        </ul>
			    	</div>
				</div>
			</div>
			<div class="panel">
				<div class="panel-heading">
					<h2>Top Sales</h2>
				</div>
				<div class="panel-body" style="margin: 20px;">
					<div class="carousel">
						<!-- {{ $count = 1 }}-->
						<ul class="carousel__thumbnails">
							@foreach($bestSellers as $bestSeller)
								@if($count < 7)
									<span>{{$count++}})</span>
					                <li>
					                    <a href="{{action('ArticleController@show', $bestSeller['id'])}}" for="slide-1">
						                    <img style="height: 180px; width: auto; border-top: 1px solid #ccc; background-color: #f7f7f7" src="{{ url("/articles/images/".$bestSeller['id'].".".$bestSeller['extension']) }}" alt="">
					                    </a>
					                    <div class="card-body">
					                        <h5 class="card-title">{{ $bestSeller['name'] }}</h5>
					                        <h5 class="card-title">Purchases: {{ $bestSeller['purchasesNum'] }}</h5>
					                        <p class="card-text text-muted">({{ $bestSeller['gender'] }} - {{ $bestSeller['price'] }} €)</p>
					                        <p>
												@php $rating = $bestSeller['assessment']; @endphp
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
					                        {!! Form::open(['url' => '/in_shopping_carts', 'method' => 'POST', 'class' => 'inline-block']) !!}
												<input type="hidden" name="article_id" value="{{$bestSeller['id']}}">
												<button type="submit" class="btn btn-info" style="position: relative;top: -22px;">
													<span class= "glyphicon glyphicon-shopping-cart"></span>
												</button>
											{!! Form::close() !!}  
					                    </div>
					                </li>
				                @endif
				    		@endforeach
				        </ul>
			    	</div>
				</div>
			</div>
		@endif
	</div>
@endsection