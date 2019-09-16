<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

Use App\InShoppingCart;
use App\ShoppingCart;
use App\PayPal;
use Auth;

class ShoppingCartController extends Controller
{

    public function __construct(){
        $this->middleware('shoppingcart');
    }

    public function index(Request $request){
        $shopping_cart = $request->shopping_cart;
    
       	$articles = $shopping_cart->articles()->get();
        
        $in_shopping_carts = $shopping_cart->inShoppingCarts()->get();

       	$total = 0; //Variable que contendrá el valor total de los articulos del carrito, calculado desde la vista

        if($articles->count() != 0)
       	    return view('shopping_cart.index', ['articles' => $articles, 'in_shopping_carts'=> $in_shopping_carts, 'total' => $total]);
        else
            return back();
    }

    public function checkout(Request $request){
        $shopping_cart = $request->shopping_cart;
        /*
        NO SE UTILIZA TRAS MIGRACION 2019_09_07_193417_drop_user_id_column_to_in_shopping_carts)
        $in_shopping_carts = InShoppingCart::where('shopping_cart_id', $shopping_cart->id)->get(); Obtenemos todas las instancias de la tabla in_shopping_carts cuyo shopping_cart_id coincida con el del carrito de la compra actual.
        
        foreach ($in_shopping_carts as $in_shopping_cart) {
            $in_shopping_cart->update(['user_id' => Auth::user()->id]); Actualizamos el campo user_id de cada registro de in_shopping_carts que contenga el shopping_cart_id del carrito de compra actual, ya que al insertarlos en el carrito hemos dejado a NULL este campo (InShoppingCartController, método store()) dado que el usuario invitado también puede añadir items al carrito y no tenemos user_id de un usuario invitado
        }
        */

        $shopping_cart->where('id', $shopping_cart->id)->update(['user_id' => Auth::user()->id]); /*MIGRACION 2019_09_07_195544_add_user_id_column_to_shopping_carts*/   /*Añadimos el user_id del usuario autenticado antes de realizar el pago*/ /*Con ésto, sabemos que usuario ha pagado que carrito*/
    
        //Y procedemos con el pago a PayPal:
        $paypal = new PayPal($request->shopping_cart);

        $payment = $paypal->generate();
        
        return redirect($payment->getApprovalLink());
    }

    public function show($id){
        $shopping_cart = ShoppingCart::where('customid', $id)->first(); /*Utilizamos where() cuando queremos buscar otro elemento diferente a la clave primaria, para la clave primaria usamos find()*/

        $order = $shopping_cart->order();

        return view('shopping_cart.completed', ['shopping_cart' => $shopping_cart, 'order' => $order]);
    }
}
