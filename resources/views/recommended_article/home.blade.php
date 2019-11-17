@extends('layouts.app')
@section('title', 'Articles eGame')
@section('content')
	<div class="text-center products-container">
		{{--@if(content_based == 'true')--}}<!-- Esta variable será seteada por el administrador para decidir que motor de recomendaciones utilizar-->
			@include('recommended_article.purchases_based_articles', compact('articles'))
		{{--@endif
		@if(colaborative_filtering == 'true')<!-- Esta variable será seteada por el administrador para decidir que motor de recomendaciones utilizar-->
			@include('recommended_article.collaborative_filtering_articles', compact('articles'))
		@endif--}}
	</div>
@endsection