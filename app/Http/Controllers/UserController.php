<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Order;
use App\Rating;
use Auth;

class UserController extends Controller
{
    public function __construct(){  /*Con el Middelware definimos que para acceder al recurso Users, hay que loguearse primero, este middleware es a nivel de controlador, también puede definirse a nivel de rutas.*/
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

        return redirect('users')->with('success', 'User created succsessfully!');
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
        return view('user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){
        /*Este método lo usaremos tanto para actualizar los datos de un usuario siendo administradores como para actualizar el perfil de usuario siendo usuarios regstrados:*/
        if(Auth::user()->role == 'Admin'){
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
            
            return redirect('users')->with('success','User updated succsessfully!');
        }
        else{
            $this->validate($request,['first_name' => 'required|string|max:70',
                'last_name' => 'required|string|max:80',
                'email' => 'required|string|email|max:50',
                'password' => 'required|string|min:6|confirmed',
                'address' => 'required|string|max:150',
                'city' => 'required|string|max:80',
                'postal_code' => 'required|integer|max:99999',
                'telephone' => 'required|integer'
            ]);
     
            User::find($id)->update([
                'first_name' => $request['first_name'],
                'last_name' => $request['last_name'],
                'email' => $request['email'],
                'password' => bcrypt($request['password']),
                'address' => $request['address'],
                'city' => $request['city'],
                'postal_code' => $request['postal_code'],
                'telephone' => $request['telephone']
            ]);
            
            return redirect('account')->with('success', 'Profile updated succsessfully!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        User::find($id)->delete();
        return redirect('users')->with('success', 'Register deleted successfully!');
    }

    public function account(){  /*Aquí enviamos a la vista los datos del perfil de usuario, así como los pedidos, valoraciones y comentarios del mismo:*/
        $user = Auth::user();
        $ratings = Rating::userRatings();
        $comments = Rating::userComments();
        $orders = Order::userOrders();
        return  view('user.account', compact('user', 'orders', 'ratings', 'comments'));
    }

    public function editProfile($id){
        $user=User::find($id);
        return view('user.edit_profile', compact('user'));
    }

    public function ratings(){
        return view('user.ratings');
    }

    public function orders(){
        return view('user.orders');
    }
}
