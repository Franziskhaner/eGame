<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\InShoppingCart;
use App\OrderedArticle;
use Auth;

class Order extends Model
{
    protected $fillable = ['recipient_name', 'line1', 'line2', 'city', 'country_code', 'state', 'postal_code', 'payment_method', 'email', 'user_id', 'status', 'custom_id', 'total'];

    public static function articles(){
        
        return $this->belongsToMany('App\Article', 'ordered_articles');
    }

    public function scopeLatest($query){  /*MÉTODOS SCOPE: empiezan por 'scope' y se declaran como métodos de objeto (no estáticos), la ventaja que presentan es que pueden ser utilizados como métodos de clase (estáticos) o como métodos de objeto, según el orden en que son llamados, ejemplo: Order::scopeEjemplo() sería un metodo estático, y Order::where()->scopeEjemplo() seria no estático, la ventaja que tienen los métodos scopes es que además se pueden concatenar con otros métodos: Order::where()->scopeEjemplo()->orderByCreated(). Un scope() siempre recibe como argumento un $objeto*/
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
    public function approve(){
        $this->updateCustomIDAndStatus();
    }

    public function updateCustomIDAndStatus(){
        $this->custom_id = $this->generateCustomID();
        $this->status = 'Approved';
        $this->save();
    }

    public function generateCustomID(){
        return md5("$this->id  $this->updated_at"); /*md5 convierte el input que se le pasa a una cadena hash, para añadir seguridad ante posibles ataques de ingeniería inversa, añadimos a nuestro input ID el tiempo actual del sistema sumándole el updated_at()*/
    }

    public function address(){
        return "$this->line1 $this->line2";
    }

    public static function  totalIncomes(){   //Suma total de las ventas de la tienda
        return Order::sum('total');
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

		/*Rellenamos el resto de campos del pedido creado en la vista delivery_options:*/
		$orderData["email"]   = $payer->payer_info->email;
        $orderData["user_id"] = Auth::user()->id;   /*Este es el usuario que ha realizado el pedido*/
        //$order = Order::where('user_id', Auth::user()->id)->get()->last();  /*Último pedido generado por el usuario actual.*/
        $order = Order::orderBy('id', 'desc')->first();  /*Último pedido generado por el usuario actual.*/
        
        $order->update([
            'recipient_name' => $orderData['recipient_name'],
            'line1' => $orderData['line1'],
            'city' => $orderData['city'],
            'postal_code' => $orderData['postal_code'],
            'state' => $orderData['state'],
            'country_code' => $orderData['country_code'],
            'email' => $orderData['email'], /*Actualizamos estos datos sobre el pedido creado en la delivery_options*/
            'user_id' => $orderData['user_id']
        ]);

    	return $order;
    }

    public static function totalUserOrders(){
        return count(Order::where('user_id', Auth::user()->id)->get());
    } 

    public static function ordersByUser(){
        $ordersByUser = Order::orderBy('created_at', 'DESC')->where('user_id', Auth::user()->id)->paginate(4);
        return $ordersByUser;
    }

    public static function articlesByOrder($id){
        $articlesByOrder = OrderedArticle::where('order_id', $id)->get();
        return $articlesByOrder;
    }
}
