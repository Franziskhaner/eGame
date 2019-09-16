<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\InShoppingCart;
use Auth;

class Order extends Model
{
    protected $fillable = ['recipient_name', 'line1', 'line2', 'city', 'country_code', 'state', 'postal_code', 'email', 'user_id', 'status', 'total', 'guide_number'];

    public static function articles(){
        
        return $this->belongsToMany('App\Article', 'ordered_articles');
    }

    public function scopeLatest($query){  /*MÉTODOS SCOPE: empiezan por 'scope' y se declaran como métodos de objeto (no estaticos), la ventaja que presentan es que pueden ser utilizados como métodos de clase (estáticos) o como metodos de objeto, según el orden en que son llamados, ejemplo: Order::scopeEjemplo() sería un metodo estático, y Order::where()->scopeEjemplo() seria no estático, la ventaja que tienen los métodos scopes es que además se pueden concatenar con otros metodos Order::where()->scopeEjemplo()->orderByCreated(). Un scope() siempre recibe como argumento un $objeto*/
        return $query->orderID()->monthly();
    }

    public function scopeOrderID($query){
        return $query->orderBy('id', 'desc');
    }

    public function scopeMonthly($query){
        return $query->whereMonth('created_at','=', date('m'));   //Nos devolvera los registros del mes actual
    }
    /*
    public function scopeArticlesOrder($query){    //Obtenemos los articulos comprados en el pedido
        $articles = InShoppingCart::where('shopping_cart_id', $this->$shopping_cart_id)->get();

        return $articles;
    }
    */

    public function address(){
        return "$this->line1 $this->line2";
    }

    public static function  totalMonth(){   //Suma total de las ventas del mes
        return Order::monthly()->sum('total');
    }

    public static function  totalMonthCount(){  //Numero de ventas del mes
        return Order::monthly()->count();
    }

    public static function createFormPayPalResponse($response, $shopping_cart){

    	$payer = $response->payer;

    	$orderData = (array) $payer->payer_info->shipping_address; /*Estamos pasando la información de shipping_address que nos devuelve PayPal a tipo array, con lo que obtendríamos algo como esto:
    	[
    		"line1" => "Calla La Rosa 5",
    		"recipient_name" => "Fran"
    		"postal_code" => "21456"
    	]
		*/
        $orderData = $orderData[key($orderData)];

		/*El resto de datos de la orden lo obtenemos asi:*/
		$orderData["email"] = $payer->payer_info->email;
		$orderData["total"] = $shopping_cart->total();
        $orderData["user_id"] = Auth::user()->id;   /*Este es el usuario que ha realizado el pedido*/
		/*$orderData["shopping_cart_id"] = $shopping_cart->id;*/ /*Deja de usarse tras migración 2019_09_07_191914_add_user_id_column_and_drop_shopping_cart_id_column_to_orders*/

    	return Order::create($orderData);
    } 
}
