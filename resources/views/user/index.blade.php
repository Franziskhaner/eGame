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
    @endif
    <div class="big-padding text-center blue-grey white-text">
      <h2>Users list</h2>
    </div>
    <table class="table table-striped">
     <thead>
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
      @if($users->count())  
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
                   <button class="btn btn-danger btn-xs" type="submit" onclick="return confirm('Are you sure to delete?')"><span class="glyphicon glyphicon-trash"></span></button>
                </form>
            </div>
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
    {{ $users->links() }}
    </div>
    <div class="floating">
     <a href="{{ route('users.create') }}" class="btn btn-primary btn-fab">
        <i class="material-icons">add</i> <!-- Añadimos el icono '+' con material design de googleapis.com-->
      </a>
    </div>
  </div>
@endsection