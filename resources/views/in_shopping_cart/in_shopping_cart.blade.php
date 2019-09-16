{!! Form::open(['url' => '/in_shopping_carts', 'method' => 'POST', 'class' => 'inline-block']) !!}
	<input type="hidden" name="article_id" value="{{$article->id}}">
	<input type="submit" value="Add to cart" class="btn btn-info">
{!! Form::close() !!}