{!! Form::open(['url' => '/in_shopping_carts', 'method' => 'POST', 'class' => 'inline-block']) !!}
	<input type="hidden" name="article_id" value="{{$articlesByContentBasedFiltering[$count]['id']}}">
	<button type="submit" class="btn btn-info">
		<span class= "glyphicon glyphicon-shopping-cart"></span>
	</button>
{!! Form::close() !!}