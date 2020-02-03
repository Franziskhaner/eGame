<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Validator;
use Cartalyst\Stripe\Laravel\Facades\Stripe;
use Stripe\Error\Card;
use App\ShoppingCart;
use App\OrderedArticle;
use App\PayPal;
use App\Order;
use Auth;


class PaymentController extends Controller
{
    public function __construct(){
        $this->middleware('shoppingcart');
    }

    /*Para procesar el pago vía PayPal y almacenar el pedido generado en BD:*/
    public function store(Request $request){
        $shopping_cart = $request->shopping_cart;

        $paypal = new PayPal($shopping_cart);

        $response = $paypal->execute($request->paymentId, $request->PayerID);

        if($response->state == 'approved'){ /*Si PayPayl acepta el pago, mostramos la información del pedido tras el pago devolviendo a la vista completed.blade.php el $order con dicha info*/
            
        	$order = Order::createFormPayPalResponse($response, $shopping_cart);
            
            $order->approve();  /*El método approve() se encargará de generar un customID único para el carrito de forma que no sea secuencial y además pondrá el estado a 'approved'*/

            $shopping_cart->update(['status' => 'approved']); /*Pasamos a approved el estado del carrito actual*/

            for($i = 0; $i < $shopping_cart->articles()->get()->count(); $i++){
                OrderedArticle::create([  /*Además añadiremos la relación de articulos pedidos en la tabla ordered_articles*/
                    'quantity' => $shopping_cart->inShoppingCarts()->where('article_id', $shopping_cart->articles()->get()[$i]->id)->first()->quantity, 
                    'order_id' => $order->id,
                    'article_id' => $shopping_cart->articles()->get()[$i]->id
                ]);
            }
            \Session::remove('shopping_cart_id');
        }

        return view('shopping_cart.completed', compact('shopping_cart', 'order'));
    }

    /**
     * Para mostrar la vista con el formulario de pago con tarjeta (Vía Stripe).
     *
     * @return \Illuminate\Http\Response
     */
    public function payWithStripe()
    {
        $order = Order::where('user_id', Auth::user()->id)->get()->last();
        return view('shopping_cart/payment_method', compact('order'));
    }

    /**
     * Para procesar la respuesta del formulario del pago con tarjeta (Vía Stripe).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postPaymentWithStripe(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'card_no' => 'required',
            'ccExpiryMonth' => 'required',
            'ccExpiryYear' => 'required',
            'cvvNumber' => 'required',
            'amount' => 'required',
        ]);
        
        $input = $request->all();
        if ($validator->passes()) {           
            $input = array_except($input,array('_token'));            
            $stripe = Stripe::make('sk_test_LOygaIM03pIyqBUe4OwSPdul00Y9gq7fdh');
            try {
                $token = $stripe->tokens()->create([
                    'card' => [
                        'number'    => $request->get('card_no'),
                        'exp_month' => $request->get('ccExpiryMonth'),
                        'exp_year'  => $request->get('ccExpiryYear'),
                        'cvc'       => $request->get('cvvNumber'),
                    ],
                ]);
                if (!isset($token['id'])) {
                    \Session::put('error','The Stripe Token was not generated correctly');
                    return redirect()->route('stripform');
                }
                $charge = $stripe->charges()->create([
                    'card' => $token['id'],
                    'currency' => 'EUR',
                    'amount'   => $request->get('amount'),
                    'description' => 'Add in wallet',
                ]);
                if($charge['status'] == 'succeeded') {
                    /**
                    * Si el pago se procesa correctamente, mostraremos la vista del pedido completado, con todos los datos del mismo. Además eliminaremos la sesión del carrito, pues ha sido completada con éxito.
                    */
                    \Session::put('success','Money add successfully in wallet');

                    $shopping_cart = $request->shopping_cart;

                    //$order = Order::where('user_id', Auth::user()->id)->get()->last();
                    $order = Order::orderBy('id', 'desc')->first();

                    $order->approve();  /*El método aprove() se encargará de generar un customID único para el carrito de forma que no sea secuencial y además pondrá el estado a 'approved'*/
                    $shopping_cart->update(['status' => 'approved']);

                    for($i = 0; $i < $shopping_cart->articles()->get()->count(); $i++){
                        OrderedArticle::create([  /*Además añadiremos la relación de articulos pedidos en la tabla ordered_articles*/
                            'quantity' => $shopping_cart->inShoppingCarts()->where('article_id', $shopping_cart->articles()->get()[$i]->id)->first()->quantity, 
                            'order_id' => $order->id,
                            'article_id' => $shopping_cart->articles()->get()[$i]->id
                        ]);
                    }

                    /*Por último, sólo nos faltaría añadir el método de pago seleccionado y el destinatario del pedido (recipient_name) en el caso de que no se haya rellenado en la vista de delivery_options, utilizaremos el nombre del usuario que haya realizado el pago en este caso:*/
                    
                    $order->update(['payment_method' => 'Credit Card']);
                    
                    if($order->recipient_name == null)
                        $order->update(['recipient_name' => Auth::user()->first_name.' '.Auth::user()->last_name]);

                    \Session::remove('shopping_cart_id');

                    return view('shopping_cart.completed', compact('shopping_cart', 'order'));
                } else {
                    \Session::put('error','Money not add in wallet!!');
                    return redirect()->route('stripform');
                }
            } catch (Exception $e) {
                \Session::put('error',$e->getMessage());
                return redirect()->route('stripform');
            } catch(\Cartalyst\Stripe\Exception\CardErrorException $e) {
                \Session::put('error',$e->getMessage());
                return redirect()->route('stripform');
            } catch(\Cartalyst\Stripe\Exception\MissingParameterException $e) {
                \Session::put('error',$e->getMessage());
                return redirect()->route('stripform');
            }
        }
        \Session::put('error','All fields are required!!');
        return redirect()->route('stripform');
    } 
}
