@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2>New Rating</h2>
                </div>
                <div class="panel-body">
                    @include('rating.form', ['rating' => $rating, 'url' => '/ratings', 'method' => 'POST'])
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
