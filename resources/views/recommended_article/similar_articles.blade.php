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
                        </div>
                    </li>
                    <!--{{ $count++ }}-->
                @endfor
            </ul>
        </div>
    </div>
</div>