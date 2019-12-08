@extends('layouts.app')
@section('title', 'Articles eGame')
@section('content')
	<div class="text-center products-container">
		@include('recommended_article.purchased_based_recommendations', compact('articlesByContentBasedFiltering'))

		@include('recommended_article.collaborative_filtering_based_recommendations', compact('articlesByCollaborativeFiltering'))
	</div>
@endsection