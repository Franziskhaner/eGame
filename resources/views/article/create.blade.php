@extends('layouts.app')
@section('content')
	<div class="container">	
		@if(Session::has('success'))
		<div class="alert alert-info">
			{{Session::get('success')}}
		</div>
		@endif
		<div class="row">
        	<div class="col-md-6 col-md-offset-3">
            	<div class="panel panel-default">
            		<div class="panel-heading">
            			<h1>New article</h1>
            		</div>
					<div class="panel-body">
						{{-- <!-- Formulario -->
						<!-- Con @include llamamos a la plantilla formulario que tenemos en la vista article.form --> --}}
						
						@include('article.form', ['article' => $article, 'url' => '/articles', 'method' => 'POST'])
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection