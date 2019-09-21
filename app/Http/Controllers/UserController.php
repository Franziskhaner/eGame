<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;

class UserController extends Controller
{
    public function __construct(){  /*Con el Middelware definimos que ´para acceder al recurso Users, hay que loguearse primero, este middleware es a nivel de controlador, también puede definirse a nivel de rutas.*/
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $users = User::orderBy('id', 'DESC')->paginate(10);
        //return view('user.index')->with(['users' => $users]);
        return view('user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        $user = new User;
        return view('user.create', compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        $this->validate($request,[ 'first_name' => 'required|string|max:70',
            'last_name' => 'required|string|max:80',
            'email' => 'required|string|email|max:50|unique:Users',
            'password' => 'required|string|min:6|confirmed',
            'address' => 'required|string|max:150',
            'city' => 'required|string|max:80',
            'postal_code' => 'required|integer|max:99999',
            'telephone' => 'required|integer',
            'role' => 'required']);
        
        User::create([
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
            'email' => $request['email'],
            'password' => bcrypt($request['password']),
            'address' => $request['address'],
            'city' => $request['city'],
            'postal_code' => $request['postal_code'],
            'telephone' => $request['telephone'],
            'role' => $request['role']
        ]);

        return redirect()->route('users.index')->with('success','Register created succsessfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id){
        $user=User::find($id);
        return  view('user.show',compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
        $user=User::find($id);
        return view('user.edit',compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){
        $this->validate($request,['first_name' => 'required|string|max:70',
            'last_name' => 'required|string|max:80',
            'email' => 'required|string|email|max:50',
            'password' => 'required|string|min:6|confirmed',
            'address' => 'required|string|max:150',
            'city' => 'required|string|max:80',
            'postal_code' => 'required|integer|max:99999',
            'telephone' => 'required|integer',
            'role' => 'required']);
 
        User::find($id)->update([
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
            'email' => $request['email'],
            'password' => bcrypt($request['password']),
            'address' => $request['address'],
            'city' => $request['city'],
            'postal_code' => $request['postal_code'],
            'telephone' => $request['telephone'],
            'role' => $request['role']
        ]);
        
        return redirect()->route('users.index')->with('success','Register updated succsessfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        User::find($id)->delete();
        return redirect()->route('users.index')->with('success','Register deleted succsessfully');
    }

    public function profile(){
        $user = Auth::user();
        return  view('user.profile', compact('user'));
    }
}
