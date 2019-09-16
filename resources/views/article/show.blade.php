<!-- resources/views/articles/show_article.blade.php -->
@extends('layouts.app')

@section('content')
	@include('article.article', compact('article', 'articles'))
@endsection