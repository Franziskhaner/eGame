@extends('layouts.app')
@section('content')
	<div class="container white">	
		@if(Session::has('success'))
		<div class="alert alert-info">
			{{Session::get('success')}}
		</div>
		@endif
		
		<h1>Edit article</h1>
		{{-- <!-- Formulario -->
		<!-- Con @include llamamos a la plantilla formulario que tenemos en la vista article.form --> --}}
		
		@include('article.form', ['article' => $article, 'url' => '/articles/'.$article->id, 'method' => 'PATCH'])
	</div>
@endsection