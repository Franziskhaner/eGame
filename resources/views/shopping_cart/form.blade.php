{!! Form::open(['url' => '/cart', 'method' => 'POST', 'class' => 'inline-block']) !!}
    <input type="submit" value="Ckechout" class="btn btn-success">
	<a href="{{route('home')}}" class="btn btn-info">Continues shopping</a>
{!! Form::close() !!}