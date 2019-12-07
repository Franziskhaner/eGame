<h2>Recommendations based on your purchases...</h2>
<div class="container">
	<!-- {{$counter = 1}} -->
	@foreach($articlesByContentBasedFiltering as $article)
		<div class="mySlides">
			<div class="numbertext">1/14</div>
			<div class="card product text-left fixed">
				<h1>
					<a href="{{action('ArticleController@show', $article['id'])}}">{{$article['name']}}</a>
				</h1>
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
		</div>
		<!-- {{$counter++}} -->
	@endforeach
	<br></br>
	<a class="prev" onclick="plusSlides(-1)">&#10094;</a>
		<a class="next" onclick="plusSlides(1)">&#10095;</a>

		<div class="row">
			<!-- {{ $counter_2 = 1}} -->
			@foreach($articlesByContentBasedFiltering as $article)
			    <div class="column">
			      <img class="demo cursor" src='{{url("/articles/images/$article[id].$article[extension]")}}' style="width:50%" onclick="currentSlide('{{ $counter_2 }}')">
			    </div>
			    <!-- {{$counter_2++}} -->
		    @endforeach
	</div>
</div>