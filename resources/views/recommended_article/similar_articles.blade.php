<div class="row">
    <div class="offset-3 col-6">
        <h1>Similar Articles</h1>
    </div>
</div>

<div class="row mb-5" style="border-bottom: 1px solid #ccc">
    <div class="col text-center">
        @foreach ($articles as $article)
            @if($article['extension'])
                <a href="{{action('ArticleController@show', $article['id'])}}">
                    <img class="p-3" style="height: 80px; width: auto; border-top: 1px solid #ccc; background-color: #f7f7f7" src='{{url("/articles/images/$article[id].$article[extension]")}}' alt="Article Image">
                </a>
            @endif
            <div class="card-body">
                <h5 class="card-title">Similarity: {{ round($article['similarity'] * 100, 1) }}%</h5>
                <p class="card-text text-muted">{{ $article['name'] }} ({{ $article['price'] }} €)</p>
            </div>
        @endforeach
    </div>
</div>