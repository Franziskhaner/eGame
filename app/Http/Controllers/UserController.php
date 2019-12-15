<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Order;
use App\Rating;
use App\Article;
use App\OrderedArticle;
use Auth;

class UserController extends Controller
{
    public function __construct(){  /*Con el Middelware definimos que para acceder al recurso Users, hay que autenticarse primero, este middleware es a nivel de controlador, también puede definirse a nivel de rutas.*/
        $this->middleware('admin', ['except' => ['ordersByUser', 'userRatings', 'account', 'editProfile']]); /*Este middleware se ha definido en el fichero Kernel.php con el nombre 'admin' e implementado en la ruta: C:\wamp64\www\eGame\app\Http\Middleware\IsAdmin.php para que sólo el usuario administrador pueda acceder a ésta vista*/
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $users = User::orderBy('id', 'DESC')->paginate(10);
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
        $this->validate($request,[
            'first_name'  => 'required|string|max:70',
            'last_name'   => 'required|string|max:80',
            'email'       => 'required|string|email|max:50|unique:Users',
            'password'    => 'required|string|min:6|confirmed',
            'address'     => 'required|string|max:150',
            'city'        => 'required|string|max:80',
            'postal_code' => 'required|integer|max:99999',
            'telephone'   => 'required|integer',
            'role'        => 'required']);
        
        User::create([
            'first_name'  => $request['first_name'],
            'last_name'   => $request['last_name'],
            'email'       => $request['email'],
            'password'    => bcrypt($request['password']),
            'address'     => $request['address'],
            'city'        => $request['city'],
            'postal_code' => $request['postal_code'],
            'telephone'   => $request['telephone'],
            'role'        => $request['role']
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
        $user = User::find($id);
        return  view('user.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
        $user = User::find($id);
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
            $this->validate($request, [
                'first_name'  => 'required|string|max:70',
                'last_name'   => 'required|string|max:80',
                'email'       => 'required|string|email|max:50',
                'password'    => 'required|string|min:6|confirmed',
                'address'     => 'required|string|max:150',
                'city'        => 'required|string|max:80',
                'postal_code' => 'required|integer|max:99999',
                'telephone'   => 'required|integer',
                'role'        => 'required'
            ]);
     
            User::find($id)->update([
                'first_name'  => $request['first_name'],
                'last_name'   => $request['last_name'],
                'email'       => $request['email'],
                'password'    => bcrypt($request['password']),
                'address'     => $request['address'],
                'city'        => $request['city'],
                'postal_code' => $request['postal_code'],
                'telephone'   => $request['telephone'],
                'role'        => $request['role']
            ]);
            
            return redirect('users')->with('success','User updated successfully!');
        }
        else{
            $this->validate($request, [
                'first_name'  => 'required|string|max:70',
                'last_name'   => 'required|string|max:80',
                'email'       => 'required|string|email|max:50',
                'password'    => 'required|string|min:6|confirmed',
                'address'     => 'required|string|max:150',
                'city'        => 'required|string|max:80',
                'postal_code' => 'required|integer|max:99999',
                'telephone'   => 'required|integer'
            ]);
     
            User::find($id)->update([
                'first_name'  => $request['first_name'],
                'last_name'   => $request['last_name'],
                'email'       => $request['email'],
                'password'    => bcrypt($request['password']),
                'address'     => $request['address'],
                'city'        => $request['city'],
                'postal_code' => $request['postal_code'],
                'telephone'   => $request['telephone']
            ]);
            
            return redirect('account')->with('success', 'Profile updated successfully!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        /*Este método se usará para eliminar usuarios desde el panel de Administrador, así como por el usuario registrado para eliminar su propia cuenta*/
        User::find($id)->delete();
        if(Auth::user()->role == 'Admin')
            return redirect('users')->with('delete', 'User deleted successfully!');
        else
            return redirect('/')->with('delete', 'User account deleted successfully!');
    }

    public function account(){  /*Aquí enviamos a la vista los datos del perfil de usuario, así como los pedidos, valoraciones y comentarios del mismo:*/
        $user = Auth::user();
        $ratings = Rating::userRatings();
        $comments = Rating::userComments();
        $orders = Order::ordersByUser();
        $totalRatings = Rating::totalUserRatings();
        $totalOrders = Order::totalUserOrders();
        return  view('user.account', compact('user', 'orders', 'ratings', 'comments', 'totalRatings', 'totalOrders'));
    }

    public function editProfile($id){
        $user = User::find($id);
        return view('user.edit_profile', compact('user'));
    }

    public function userRatings(){
        $ratings = Rating::userRatings();
        $total = Rating::totalUserRatings();
        return view('user.your_ratings', compact('ratings', 'total'));
    }

    public function ordersByUser(){
        $ordersByUser = Order::ordersByUser(); /*Pedidos realizados por el usuario de la sesión actual*/
        $total = Order::totalUserOrders();

        $articlesIdByOrder = array();   /*Array que almacenará los IDs de los artículos por cada pedido de dicho usuario*/
        
        $orderIdByUser = array(); /*Almacenará los IDs de los pedidos realizados por el usuario*/

        foreach ($ordersByUser as $orderByUser){
            $articlesByOrder = Order::articlesByOrder($orderByUser->id); /*Artículos comprados por cada pedido (Order) del usuario de la sesión actual*/
            $orderIdByUser[] = $orderByUser->id;    /*Vamos quedándonos con los IDs de los pedidos*/
            foreach ($articlesByOrder as $articleByOrder)   /*Por cada pedido realizado se pueden comprar 1 o varios artículos, así que almacenanos los IDs de dichos artículos para posteriormente tener más datos de ellos (nombre, precio, ...)*/
                $articlesIdByOrder[] = $articleByOrder->article_id;
        }

        $articlesIdByOrder = array_unique($articlesIdByOrder); /*Eliminamos las instancias duplicadas de dichos IDs, para ello usamos array_unique()*/

        $articles = Article::wherein('id', $articlesIdByOrder)->get(); /*Sacamos las instancias (filas) de los articulos pedidos por el usuario de la tabla articles (filtrando por los Ids obtenidos arriba)*/

        $orderedArticles = OrderedArticle::wherein('order_id', $orderIdByUser)->get(); /*También le pasaremos a la vista 'user.orders' la relación de Artículos-Pedidos hechos por el usuario, para poder conocer el artículo o artículos exactos y la cantidad comprada de dichos artículos (campo 'quantity' de dicha tabla) por cada pedido*/
        //print_r($articles);

        return view('user.your_orders', compact(['total', 'ordersByUser', 'articles', 'orderedArticles']));
    }
}
