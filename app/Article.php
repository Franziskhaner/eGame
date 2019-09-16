<?php
	namespace App;
	use Illuminate\Database\Eloquent\Model;

	use App\InShoppingCart;
	use App\ShoppingCart;

	class Article extends Model
	{
		protected $table = 'articles';

		//Agregamos los datos de la tabla
		protected $fillable =['id', 'name', 'price', 'quantity', 'release_date', 'players_num', 'gender', 'platform', 'description', 'assessment'];

		public function scopeLatest($query){	//Nos va a devolver los últimos productos.
			return $query->orderBy('id', 'asc');
		}

		public function paypalItem(){ /*Es llamada desde el modelo PayPal.php para indicar a Paypal toda la info de nuestro carrito.*/
			
			echo $shopping_cart_id = InShoppingCart::get()->last()->shopping_cart_id;	//Obtenemos el id del carrito actual
			echo $in_shopping_carts = InShoppingCart::get()->where('shopping_cart_id', $shopping_cart_id);	//Con ese id sacamos todas las istancias del carrito actual
			
			$in_shopping_cart_article_quantity = $in_shopping_carts->where('article_id', $this->id)->first()->quantity;	//Finalmente obtenemos la instancia del articulo actual y nos quedamos con las cantidades del mismo para pasarsela al item() de PayPal:
		
			return \PaypalPayment::item()->setName($this->name)
						->setDescription($this->description)
						->setCurrency('EUR')
						->setQuantity($in_shopping_cart_article_quantity)
						->setPrice($this->price / 100);
		}

		/*
		create(['name'=> 'NameX' 'price' => 'PriceX', 'release_date' => 'RelaseDateX', 'quantity' => 'QuantityX', 'description' => 'DescX', 'insert_date' => 'InsertDateX', 'vat' => 'VatX']);*/
	}
?>