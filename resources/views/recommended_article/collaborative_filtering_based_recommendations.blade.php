@if(count($articlesByCollaborativeFiltering) > 1)
<div class="panel panel-default">
	<div class="panel-heading">
		<h2>Recommendations based on other similar users...</h2>
	</div>
	<br><br>
	<div class="panel-body">
		<div class="carousel">
    		<!-- {{ $count = 0 }}-->
			<ul class="carousel__thumbnails">
				@for($i = 0; $i < sizeof($articlesByCollaborativeFiltering); $i++)
	                <li>
	                    <a href="{{action('ArticleController@show', $articlesByCollaborativeFiltering[$count]['id'])}}" for="slide-1">
		                    <img src="{{ url("/articles/images/".$articlesByCollaborativeFiltering[$count]['id'].".".$articlesByCollaborativeFiltering[$count]['extension']) }}" alt="">
	                    </a>
	                    <div class="card-body">
	                        <h5 class="card-title">{{ $articlesByCollaborativeFiltering[$count]['name'] }}</h5>
	                        <p class="card-text text-muted">({{ $articlesByCollaborativeFiltering[$count]['gender'] }} - {{ $articlesByCollaborativeFiltering[$count]['price'] }} €)</p>
	                        <p>
								@php $rating = $articlesByCollaborativeFiltering[$count]['assessment'] @endphp
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
								<input type="hidden" name="article_id" value="{{$articlesByCollaborativeFiltering[$count]['id']}}">
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
@endif