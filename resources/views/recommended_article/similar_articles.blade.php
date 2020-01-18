<div class="panel panel-default">
    <div class="panel-heading">
        <h2>Similar Articles</h2>
    </div>
    <div class="panel-body">
        <div class="carousel">
            <!-- {{ $count = 0 }}-->
            <ul class="carousel__thumbnails">
                @for($i = 0; $i < 6; $i++)
                    <li>
                        <a href="{{action('ArticleController@show', $articles[$count]['id'])}}" for="slide-1">
                            <img src="{{ url("/articles/images/".$articles[$count]['id'].".".$articles[$count]['extension']) }}" alt="">
                        </a>
                        <div class="card-body">
                            <h5 class="card-title">Similarity: {{ round($articles[$count]['similarity'] * 100, 1) }}%</h5>
                            <p class="card-text text-muted">{{ $articles[$count]['name'] }}</p>
                            <p class="card-text text-muted">({{ $articles[$count]['gender'] }} - {{ $articles[$count]['price'] }} €)</p>
                            <p>
                                @php $rating = $articles[$i]['assessment'] @endphp
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
                                <input type="hidden" name="article_id" value="{{$articles[$i]['id']}}">
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