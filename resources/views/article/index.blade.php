<!--/resources/views/articles/articles.blade.php -->

@extends('layouts.app')
@section('content')
  <div class="container">
    <div class="big-padding text-center blue-grey white-text">
      <h2>Articles List</h2>
    </div>
    <table class="table table-striped">
      <thead>
         <th>ID</th>
         <th>Name</th>
         <th>Price</th>
         <th>Quantity</th>
         <th>Release date</th>
         <th>Players number</th>
         <th>Gender</th>
         <th>Platform</th>
         <th>Description</th>
         <th>Assesment</th>
         <th>Actions</th>
      </thead>
      <tbody>
      @if($articles->count())  
        @foreach($articles as $article)  
          <tr>
            <td>{{$article->id}}</td>
            <td>{{$article->name}}</td>
            <td>{{$article->price}}</td>
            <td>{{$article->quantity}}</td>
            <td>{{$article->release_date}}</td>
            <td>{{$article->players_num}}</td>
            <td>{{$article->gender}}</td>
            <td>{{$article->platform}}</td>
            <td>{{$article->description}}</td>
            <td>{{$article->assessment}}</td>
            <td>
              @if($article->extension)
                <a class="btn btn-info btn-xs" href="{{url('/articles/'."$article->id")}}"><span class="glyphicon glyphicon-eye-open"></span></a>
              @endif
              <a class="btn btn-primary btn-xs" href="{{action('ArticleController@edit', $article->id)}}" >
                <span class="glyphicon glyphicon-pencil"></span>
              </a>
              <form action="{{action('ArticleController@destroy', $article->id)}}" method="post">
                  {{csrf_field()}}
                  <input name="_method" type="hidden" value="DELETE">
                  <button class="btn btn-danger btn-xs" type="submit" onclick="return confirm('Are you sure to delete?')">
                    <span class="glyphicon glyphicon-trash"></span>
                  </button>
              </form>
            </td>
          </tr>
        @endforeach 
      @else
        <tr>
          <td colspan="8">There is not register!!</td>
        </tr>
      @endif
      </tbody>
    </table>
    {{ $articles->links() }} <!--Con este método, mostramos el paginador en la página de Artículos-->
  </div> 

  <div class="floating">
    <a href="{{ route('articles.create') }}" class="btn btn-primary btn-fab">
      <i class="material-icons">add</i> <!-- Añadimos el icono '+' con material design de googleapis.com-->
    </a>
  </div>
@endsection