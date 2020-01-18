<div class="panel panel-default">
	<div class="panel-heading">
		<h2>Recommendations based on your purchases...</h2>
	</div>
	<br><br>
	<div class="panel-body">
		<div class="carousel">
			<!-- {{ $count = 0 }}-->
			<ul class="carousel__thumbnails">
				@for($i = 0; $i < 6; $i++)
	                <li>
	                    <a href="{{action('ArticleController@show', $articlesByContentBasedFiltering[$count]['id'])}}" for="slide-1">
		                    <img style="height: 200px; width: 160px; border-top: 1px solid #ccc; background-color: #f7f7f7" src="{{ url("/articles/images/".$articlesByContentBasedFiltering[$count]['id'].".".$articlesByContentBasedFiltering[$count]['extension']) }}" alt="">
	                    </a>
	                    <div class="card-body">
	                        <h5 class="card-title">{{ $articlesByContentBasedFiltering[$count]['name'] }}</h5>
	                        <p class="card-text text-muted">({{ $articlesByContentBasedFiltering[$count]['gender'] }} - {{ $articlesByContentBasedFiltering[$count]['price'] }} €)</p>
	                        <p>
								@php $rating = $articlesByContentBasedFiltering[$count]['assessment'] @endphp
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
								<input type="hidden" name="article_id" value="{{$articlesByContentBasedFiltering[$count]['id']}}">
								<button type="submit" class="btn btn-info" style="position: relative;top: -22px;">
									<span class= "glyphicon glyphicon-shopping-cart"></span>
								</button>
							{!! Form::close() !!}
	                    </div>
	                </li>
		            <!--{{ $count++ }}-->
	    		@endfor
	        </ul>
	    </div>
	</div>
</div>