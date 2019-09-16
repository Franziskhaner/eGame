<!-- resources/views/articles/rating.blade.php -->
@extends('layouts.app')
@section('content')
<body>
	<h2>Rate your game</h2>

	<div id="rateYo"></div>
	
	<script>
		alert('robee');
		$( document ).ready(function() {
            $("#rateYo").rateYo({
                    rating: 3.6
                });
        });
	</script>
	
</body>
@endsection