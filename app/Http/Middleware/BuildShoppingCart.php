<?php

namespace App\Http\Middleware;

use Closure;

use App\ShoppingCart;

class BuildShoppingCart
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        /*Un Middleware es una función que se ejecuta en medio del ciclo entre el momento en que se envía la petición desde el navegador al servidor y éste da la respuesta. Los Middlewares se van ejecutando en orden uno tras otro y luego se ejecuta la función del controlador. Son útiles para definir variables, permisos, validaciones, etc.*/
        $shopping_cart_id = \Session::get('shopping_cart_id');/*La primera vez que entremos en la página, nuestro shopping_cart_id será NULL, por lo que al llamar al metodo findOrCreateBySessionID() nos creará un carrito de compras en BD con su respectivo ID:*/

        $shopping_cart = ShoppingCart::findOrCreateBySessionID($shopping_cart_id);

        $request->shopping_cart = $shopping_cart;

        return $next($request); //Hace que el middleware mande la petición a quien sea que siga, ya sea otro middleware u al controlador.
    }
}
