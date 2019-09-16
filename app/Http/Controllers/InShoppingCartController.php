<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\ShoppingCart;
use App\InShoppingCart;
use App\Article;
use Auth;

class InShoppingCartController extends Controller
{
    public function __construct(){
        $this->middleware('shoppingcart');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $shopping_cart = $request->shopping_cart;

        /*Comprobamos si el artículo seleccionado ya existe en el carrito*/
        $in_shopping_carts = InShoppingCart::where('shopping_cart_id', $shopping_cart->id)->get(); /*Obtenemos todas las instancias de la tabla in_shopping_carts cuyo shopping_cart_id coincida con el del carrito de la compra actual.*/

        $article = Article::find($request->article_id); //Nos quedamos con el articulo que hemos añadido al carrito para luego modificar el stock del mismo.
        
        $exists = false;

        foreach($in_shopping_carts as $in_shopping_cart){   //Recorremos todas esas instancias para comprobar si el article_id del articulo actual seleccionado coincide con el article_id de alguna de las instancias ya existentes en el carrito
            if($in_shopping_cart->article_id == $request->article_id){   //Si existe aumentamos el campo quantity de esa instancia a 1 y ponemos $exists a true.
                $in_shopping_cart->update(['quantity' => $in_shopping_cart->quantity+1]);
                $exists = true;
                $article->update(['quantity'=> $article->quantity-1]); //Además volvemos a reducir en 1 el stock de dicho artículo.
            }   
        }
        
        if($exists == false){  //Si al final no existe creamos una nueva instancia con ese artículo.
            $response = InShoppingCart::create([
                    'user_id' => NULL,    /*Si no se ha logueado nadie aún (usuario invitado), lo dejamos a NULL y cuando se vaya a hacer checkout, se deberá loguear y en ese momento cogemos el user_id y lo actualizamos en este mismo registro de la tabla in_shopping_carts. Ésto lo hacemos en ShoppingCartController, en el método checkout(), antes de enviar la petición de pago a Paypal.*/
                    'shopping_cart_id' => $shopping_cart->id,
                    'article_id'=> $request->article_id,
                    'quantity' => 1
                    ]);
            $article->update(['quantity' => $article->quantity-1]);   //Y reducimos el stock de dicho artículo en 1.
        }
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $shopping_cart_id = InShoppingCart::find($id)->shopping_cart_id;   //Obtenemos el id del carrito de la compra actual.

        $in_shopping_cart = InShoppingCart::find($id);
        
        $article = Article::find($in_shopping_cart->article_id); //Nos quedamos con el articulo que hemos quitado del carrito para modificar el stock del mismo.
        
        if($in_shopping_cart->quantity > 1){    //Si hay más de un artículo del mismo tipo en el carro, reducimos la cantidad en 1:
            $in_shopping_cart->update(['quantity' => $in_shopping_cart->quantity-1]);
            $article->update(['quantity' => $article->quantity+1]);   //Y además aumentamos en 1 el stock de dicho artículo ya que al final no vamos a comprarlo.
            return back();
        }
        else{   //Si no hay más de un artículo del mismo tipo, comprobamos si es la última instancia del carrito o no:
            if(InShoppingCart::where('shopping_cart_id', $shopping_cart_id)->count() == 1){ //Si sólo hay 1 instancia en la tabla in_shopping_carts con el id del carrito actual, quiere decir que es él último artículo por borrar del carro, así que lo borramos, aumentamos el stock de dicho artículo en 1 en la tabla articles y redirigimos a la vista home:
                $in_shopping_cart->delete();
                $article->update(['quantity' => $article->quantity+1]);
                return redirect('/');
            }
            else{   //Si hay más de 1 instancia con el id del carrito entonces no es el último artículo del carro y podemos redirigir tranquilamente al carrito de nuevo:
                $in_shopping_cart->delete();
                $article->update(['quantity' => $article->quantity+1]);   //Pero no sin antes aumentar en 1 el stock de dicho artículo ya que al final no vamos a comprarlo.
                return back();
            }
        }
    }
}
