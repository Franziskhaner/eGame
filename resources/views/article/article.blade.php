<div class="container text-center">
	<div class="card product text-left">
		@if(Auth::check() && Auth::user()->role == 'Admin') {{-- Con ésto comprobamos si el usuario ha iniciado sesión y además posee el role Administrador, en ese caso se le darán permisos de administrador sobre el artículo--}}
			<div class="absolute actions">
				<form action="{{action('ArticleController@destroy', $article->id)}}" method="post">
                	{{csrf_field()}}
                    <a class="btn btn-primary btn-xs" href="{{action('ArticleController@edit', $article->id)}}" >
						<span class="glyphicon glyphicon-pencil"></span>
					</a>
                  	<input name="_method" type="hidden" value="DELETE">
                  	<button class="btn btn-danger btn-xs" type="submit" onclick="return confirm('Are you sure to delete?')"><span class="glyphicon glyphicon-trash"></span></button>
              	</form>
			</div>
		@endif

		<h1>{{$article->name}}</h1>
		<div class="row">
			<div class="col-sm-6 col-xs-12">
				@if($article->extension)
					<img src='{{url("/articles/images/$article->id.$article->extension")}}' class="product-avatar">
				@endif
			</div>
			<div class="col-sm-6 col-xs-12">
				<p>
					<strong>Price:</strong><p>{{$article->price}} €</p>
					<strong>Platform:</strong><p>{{$article->platform}}</p>
					<strong>Gender:</strong><p>{{$article->gender}}</p>
					<strong>Release Date:</strong><p>{{$article->release_date}}</p>
					<strong>Players Number:</strong><p>{{$article->players_num}}</p>
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
				</p>
				@if($article->quantity > 0)
					@include('in_shopping_cart.form', compact('article'))
				@else
					<span style="color:red">We are so sorry!, this product is actually out of stock =(</span>
				@endif
			</div>
		</div>
		<div class="row" style="position: relative; margin: 15px;">
			<strong>Description:</strong>
			<p>{{$article->description}}</p>
		</div>
	</div>
	<br><br>
	@include('recommended_article.similar_articles', compact('articles'))
	<br><br>
	@if(count($reviews))
		<div class="panel panel-default">
			<div class="panel-heading">
				<h2>Opinions and comments for other users...</h2>
			</div>
			<br>
			@foreach($reviews as $review)
				<div class="row">
					<div class="col-sm-2">
						<strong>{{$users->where('id', $review->user_id)->first()->first_name}}</strong>
					</div>
					<div class="col-sm-3">
						{{$review->created_at}}
					</div>	
					<div class="col-sm-2">
						@php $rating = $review->score; @endphp 
						<div class="placeholder" style="position: absolute;color: lightgray;">
				            <i class="fa fa-star"></i>
				            <i class="fa fa-star"></i>
				            <i class="fa fa-star"></i>
				            <i class="fa fa-star"></i>
				            <i class="fa fa-star"></i>
				            <span class="small">({{ $rating }})</span>
				        </div>
				        <div class="overlay" style="position: absolute;top: -2px;">
				            @while($rating>0)
				                @if($rating >0.5)
				                    <i class="fa fa-star checked"></i>
				                @else
				                    <i class="fa fa-star-half checked"></i>
				                @endif
				                @php $rating--; @endphp
				            @endwhile
				        </div>
					</div>
					<div class="col-sm-4">
						{{$review->comment}}
					</div>
				</div>
			@endforeach
			<br></br>
		</div>
	@endif
</div>