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
                <div class="col-md-7">
                    <h2>Users</h2>
                </div>
                <div class="col-md-5">
                    <form action="{{action('MainController@crudSearch', 'users')}}" method="get">  
                        <input list="users" name="crud_search" placeholder="Search an user..." style="padding-top: 5px; padding-bottom: 7px; width: 60%;">
                        <datalist id="users">
                            @foreach($users as $user)
                                <option value="{{ $user->first_name }}">{{$user->last_name}}</option>
                            @endforeach
                        </datalist>
                        <input type="submit" value="Search" class="btn btn-primary">
                    </form>
                </div>  
            </div>
        </div>
        @if($users->count())
            <table class="table table-striped">
                <thead style="background-color:#3f51b5; color:white">
                    <th>ID</th>
                    <th>Frst name</th>
                    <th>Last name</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>City</th>
                    <th>Postal Code</th>
                    <th>Telephone</th>
                    <th>Role</th>
                    <th>Actions</th>
                </thead>
                <tbody>
                    @foreach($users as $user)  
                    <tr>
                        <td>{{$user->id}}</td>
                        <td>{{$user->first_name}}</td>
                        <td>{{$user->last_name}}</td>
                        <td>{{$user->email}}</td>
                        <td>{{$user->address}}</td>
                        <td>{{$user->city}}</td>
                        <td>{{$user->postal_code}}</td>
                        <td>{{$user->telephone}}</td>
                        <td>{{$user->role}}</td>
                        <td>
                            <div class="form-group" style="display: inline-block;">
                                <a class="btn btn-primary btn-xs" href="{{action('UserController@edit', $user->id)}}" >
                                    <span class="glyphicon glyphicon-pencil"></span>
                                </a>
                                <form action="{{action('UserController@destroy', $user->id)}}" method="post">
                                    {{csrf_field()}}
                                    <input name="_method" type="hidden" value="DELETE">
                                    <button class="btn btn-danger btn-xs" type="submit" onclick="return confirm('Are you sure to delete?')">
                                        <span class="glyphicon glyphicon-trash"></span>
                                    </button>
                                </form>
                            </div>
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
        {{ $users->links() }}
        <div class="floating">
            <a href="{{ route('users.create') }}" class="btn btn-primary btn-fab">
                <i class="material-icons">add</i> <!-- Añadimos el icono '+' con material design de googleapis.com-->
            </a>
        </div>
    </div>
</div>
@endsection