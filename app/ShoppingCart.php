<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShoppingCart extends Model
{
	//Mass assignment (estos atributos, son lo que podrán ser modificados a través de las funciones del modelo Eloquent de Laravel (create, delete, etc))
	protected $fillable = ['status'];

	public function approve(){
		$this->updateCustomIDAndStatus();
	}

	public function generateCustomID(){
		return md5("$this->id  $this->updated_at"); /*md5 convierte el input que se le pasa a una cadena hash, para añadir seguridad ante posibles ataques de ingeniería inversa, añadimos a nuestro input ID el tiempo actual del sistema sumándole el updated_at()*/
	}

	public function updateCustomIDAndStatus(){
		$this->customid = $this->generateCustomID();
		$this->status = 'approved';
		$this->save();
	}

	public function inShoppingCarts(){
		return $this->hasMany('App\InShoppingCart');
	}

	public function order(){
		return $this->hasOne('App\Order')->first();
	}

	public function articles(){
		return $this->belongsToMany('App\Article', 'in_shopping_carts');
	}

	public function articlesSize(){
		return  $this->inShoppingCarts()->get()->sum('quantity');	//Esta es la cantidad de artículos que se le pasa a todas las vistas desde el Provider ShoppingCartProvider.php y es la que recibe el icono del carrito
	}

	public function total(){	//Este es el total del carrito de la compra que recibe el método amount() desde PayPal.php para indicar el total del carro a PayPal
		$sum = 0;
		$in_shopping_carts = $this->inShoppingCarts()->get();
		$articles = $this->articles()->get();

		for($i = 0; $i < $articles->count(); $i++){		//Vamos calculando el total del carro sumando las cantidades de cada item del carrito
			$sum = $sum + $in_shopping_carts[$i]->quantity * $articles[$i]->price;
		}
		
		return $sum;
	}

	public function totalEUR(){
		return $this->total() / 100;	/*Dividimos el precio de la suma de los artículos del carrito entre 100 para que no nos quedemos sin dinero rápidamente en nuestro monedero*/
	}

	public static function findOrCreateBySessionID($shopping_cart_id){
		if($shopping_cart_id)
			//Si existe vamos a buscar un carrito de compras con este ID
			return ShoppingCart::findBySession($shopping_cart_id);
		else
			//Si no, creamos el carrito de compras
			return ShoppingCart::createWithoutSession();
	}

	public static function findBySession($shopping_cart_id){
		return ShoppingCart::find($shopping_cart_id);
	}

	public static function createWithoutSession(){

		return ShoppingCart::create([
			'status' => 'incompleted'
		]);
		//Creamos el shopping_cart con estado inicial 'incompleted', sería el equivalente a estas 4 líneas de código:
		/*
		$shopping_cart = new ShoppingCart;

		$shopping_cart->status = 'incompleted';

		$shopping_cart->save();

		return $shopping_cart;
		*/
	}
}
