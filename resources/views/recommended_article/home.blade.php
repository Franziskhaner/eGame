@extends('layouts.app')
@section('title', 'Articles eGame')
@section('content')
	<div class="text-center products-container">
		{{--@if(content_based == 'true')--}}<!-- Esta variable será seteada por el administrador para decidir que motor de recomendaciones utilizar-->
			@include('recommended_article.purchased_based_recommendations', compact('articlesByContentBasedFiltering'))
		{{--@endif
		@if(colaborative_filtering == 'true')<!-- Esta variable será seteada por el administrador para decidir que motor de recomendaciones utilizar-->
		@endif--}}
			@include('recommended_article.collaborative_filtering_based_recommendations', compact('articlesByCollaborativeFiltering'))
	</div>
@endsection