<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\ShoppingCart;

class ShoppingCartProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer("*", function($view){
            //Con los view composer Laravel nos permite inyectar variables dentro de las vistas. Con el primer argumento indicamos a que vista/s inyectamos la variable en cuestión, en este caso indicamos "*" que quiere decir a TODAS las vistas y con el segundo argumento indicamos la variable en sí.

            $shopping_cart_id = \Session::get('shopping_cart_id');  //La primera vez que entremos en la página, nuestro shopping_cart_id será NULL, por lo que al llamar al metodo findOrCreateBySessionID() nos creará un carrito de compras en BD con su respectivo ID:
            $shopping_cart = ShoppingCart::findOrCreateBySessionID($shopping_cart_id);

            //Ahora ese ID se le asignará al shopping_cart_id de nuestra sesión tal que así:
            \Session::put('shopping_cart_id', $shopping_cart->id);

            //De esta forma, cuando volvamos a reiniciar la página, tendremos nuestro shopping_cart_id de la sesión anterior y no perderemos nuestro carrito de la compra. 

            $view->with('articlesCount', $shopping_cart->articlesSize());   //Este parametro es llamada desde la plantilla 'layouts.app' para obtener el numero de artículos del carrito de la compra.
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
