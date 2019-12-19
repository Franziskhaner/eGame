@extends('layouts.app')
@section('content')
<div class="container">
    @if(session('success'))
        <div class="alert alert-success">
            {{session('success')}}
        </div>
    @elseif(session('delete'))
        <div class="alert alert-success">
            {{session('delete')}}
        </div>
    @elseif(session('error'))
        <div class="custom-alerts alert alert-danger fade in">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
            {{session('error')}}
        </div>
        <?php Session::forget('error');?>
    @endif
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-8">
                    <h2>Articles</h2>
                </div>
                <div class="col-md-4">
                    <form action="{{action('MainController@crudSearch', 'articles')}}" method="get">
                        <input list="articles" name="crud_search">
                        <datalist id="articles">
                            @foreach($articles as $article)
                                <option value="{{ $article->name }}">{{$article->name}}</option>
                            @endforeach
                        </datalist>
                        <input type="submit" value="Search" class="btn btn-primary">
                    </form>
                </div>
            </div>
        </div>
        @if($articles->count()) 
            <table class="table table-striped">
                <thead style="background-color:#3f51b5; color:white">
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
                </tbody>
            </table>
        @else
            <tr>
                <td colspan="8">There is not register!!</td>
            </tr>
        @endif
        {{ $articles->links() }} <!--Con este método, mostramos el paginador en la página de Artículos--> 
        <div class="floating">
            <a href="{{ route('articles.create') }}" class="btn btn-primary btn-fab">
                <i class="material-icons">add</i> <!-- Añadimos el icono '+' con material design de googleapis.com-->
            </a>
        </div>
    </div>
</div>
@endsection