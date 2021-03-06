<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\User;

class OrderController extends Controller
{
    public function __construct(){  /*Con el Middelware definimos que para acceder al recurso Users, hay que autenticarse primero, este middleware es a nivel de controlador, también puede definirse a nivel de rutas.*/
        $this->middleware('admin', ['except' => ['show']]); /*Este middleware se ha definido en el fichero Kernel.php con el nombre 'admin' e implementado en la ruta: C:\wamp64\www\eGame\app\Http\Middleware\IsAdmin.php para que sólo el usuario administrador pueda acceder a las vistas de este controlador. Dejamos el método show como excepción para que el usuario registrado pueda acceder a la vista de shopping_completed a través del link permanente.*/
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::orderBy('id', 'DESC')->paginate(10);
        $totalIncomes = Order::totalIncomes();
        $totalCount = Order::count();
        $totalMonth = Order::totalMonth();
        $totalMonthCount = Order::totalMonthCount();

        return view('order.index', compact(['orders', 'totalIncomes', 'totalCount', 'totalMonth', 'totalMonthCount']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $order = new Order;
        $users = User::all();
        return view('order.create', compact(['order', 'users']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'line1'          => 'required|string',
            'city'           => 'required|string',
            'postal_code'    => 'required|integer|max:99999',
            'country_code'   => 'required|string',
            'state'          => 'required|string',
            'payment_method' => 'required|string',
            'status'         => 'required|string',
            'total'          => 'required|integer', 
            'user_id'        => 'required|integer'
        ]);
        
        Order::create([
            'recipient_name' => $request['recipient_name'],
            'line1'          => $request['line1'],
            'line2'          => $request['line2'],
            'city'           => $request['city'],
            'postal_code'    => $request['postal_code'],
            'country_code'   => $request['country_code'],
            'state'          => $request['state'],
            'payment_method' => $request['payment_method'],
            'email'          => $request['email'],
            'status'         => $request['status'],
            'total'          => $request['total'],
            'user_id'        => $request['user_id']
        ]);

        return redirect('orders')->with('success', 'Order created successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = Order::where('custom_id', $id)->first(); /*Utilizamos where() cuando queremos buscar otro elemento diferente a la clave primaria, para la clave primaria usamos find()*/

        return view('shopping_cart.completed', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $order = Order::find($id);
        $users = User::All();
        return view('order.edit', compact(['order', 'users']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'line1'          => 'required|string',
            'city'           => 'required|string',
            'postal_code'    => 'required|integer|max:99999',
            'country_code'   => 'required|string',
            'state'          => 'required|string',
            'payment_method' => 'required|string',
            'status'         => 'required|string',
            'total'          => 'required|integer', 
            'user_id'        => 'required|integer'
        ]);
        
        $order = Order::find($id);

        $order->update($request->all());

        if($order->save())
            return redirect('orders')->with('success', 'Order updated successfully!');
        else
            return view('order.edit', compact('order'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Order::find($id)->delete();
        return redirect()->route('orders.index')->with('success','Order deleted successfully!');
    }

    public function cancelOrder($id)
    {   /*Elimina un pedido creado tras elegir la dirección de entrega, cuando se cancela desde la vista 'payment_method' antes de proceder al cobro.*/
        Order::find($id)->delete();

        return redirect()->route('home');
    }
}
