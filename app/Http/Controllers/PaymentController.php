<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\ShoppingCart;
use App\OrderedArticle;
use App\PayPal;
use App\Order;

class PaymentController extends Controller
{
    public function __construct(){
        $this->middleware('shoppingcart');
    }

    public function store(Request $request){
    	
        $shopping_cart = $request->shopping_cart;

        $paypal = new PayPal($shopping_cart);

        $response = $paypal->execute($request->paymentId, $request->PayerID);

        if($response->state == 'approved'){ /*Si PayPayl acepta el pago, mostramos la información del pedido tras el pago devolviendo a la vista completed.blad.php el $order con dicha info*/
            \Session::remove('shopping_cart_id');
        	$order = Order::createFormPayPalResponse($response, $shopping_cart);
            $shopping_cart->approve();  /*El método aprove() se encargará de generar un customID único para el carrito de forma que no sea secuencial y además pondrá el estado a 'approved'*/
            
            for($i = 0; $i < $shopping_cart->articles()->get()->count(); $i++){
                OrderedArticle::create([  /*Además añadiremos la relación de articulos pedidos en la tabla ordered_articles*/
                    'quantity' => $shopping_cart->inShoppingCarts()->where('article_id', $shopping_cart->articles()->get()[$i]->id)->first()->quantity, 
                    'order_id' => $order->id,
                    'article_id' => $shopping_cart->articles()->get()[$i]->id
                ]);
            }
        }

        return view('shopping_cart.completed', ['shopping_cart' => $shopping_cart, 'order' => $order]);
        //dd($order);
    }
}
