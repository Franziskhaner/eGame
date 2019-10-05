<?php
namespace App;
use Illuminate\Database\Eloquent\Model;

use App\InShoppingCart;
use App\ShoppingCart;
use App\OrderedArticle;
use App\Order;
use App\Article;
use Auth;

class Article extends Model
{
	protected $table = 'articles';

	//Agregamos los datos de la tabla
	protected $fillable =['id', 'name', 'price', 'quantity', 'release_date', 'players_num', 'gender', 'platform', 'description', 'assessment'];

	public function scopeLatest($query){	//Nos va a devolver los últimos productos.
		return $query->orderBy('id', 'asc');
	}

	public function paypalItem(){ //Es llamada desde el modelo PayPal.php para indicar a Paypal toda la info de nuestro carrito.
		
		$shopping_cart_id  = ShoppingCart::where('user_id', Auth::user()->id)->get()->last()->id; //Obtenemos el id del carrito del usuario con sesión actual.
		$in_shopping_carts = InShoppingCart::get()->where('shopping_cart_id', $shopping_cart_id);	//Con ese id sacamos todas las istancias del carrito actual
		
		$in_shopping_cart_article_quantity = $in_shopping_carts->where('article_id', $this->id)->first()->quantity;	//Finalmente obtenemos la instancia del articulo actual y nos quedamos con las cantidades del mismo para pasarsela al item() de PayPal:
	
		return \PaypalPayment::item()->setName($this->name)
					->setDescription($this->description)
					->setCurrency('EUR')
					->setQuantity($in_shopping_cart_article_quantity)
					->setPrice($this->price / 100);
	}

	public static function generateArticlesMatrix(){ /*Este método generará una matriz que contendrá un vector asociativo con los atributos necesarios por cada artículo de la Base de Datos y que se utilizará para calcular los artículos similares posteriormente*/
		$articlesDB = Article::all();
        
        $articlesAsociativeMatrix = array ();

        for($i = 0; $i < sizeof($articlesDB); $i++){
            $articlesAsociativeMatrix[$i] = array(
                'id'           => $articlesDB[$i]->id,
                'name'         => $articlesDB[$i]->name,
                'price'        => $articlesDB[$i]->price,
                'gender'       => $articlesDB[$i]->gender,
                'platform'     => $articlesDB[$i]->platform,
                'quantity'     => $articlesDB[$i]->quantity,
                'extension'    => $articlesDB[$i]->extension,
                'assessment'   => $articlesDB[$i]->assessment,
                'players_num'  => $articlesDB[$i]->players_num,
                'release_date' => $articlesDB[$i]->release_date
            );
        }

        return $articlesAsociativeMatrix;
	}

	public static function filteredBySimilarArticles($id){
        
        $articlesMatrix 			  = Article::generateArticlesMatrix(); 
        $articleSimilarity 			  = new ContentBasedFiltering($articlesMatrix);
        $similarityMatrix  			  = $articleSimilarity->calculateSimilarityMatrix();
        $articlesSortedBySimilarity   = $articleSimilarity->getArticlesSortedBySimilarity($id, $similarityMatrix); /*Ordenamos la matriz de similuitudes pasándole el id ($id) del artículo indicado en la URL para hacer las recomendaciones en base a él*/

        return $articlesSortedBySimilarity;
	}

	public static function filteredByUserPurchases(){

		$ordersByUser  = Order::where('user_id', Auth::user()->id)->get();	/*Obtenemos los pedidos realizados por el usuario actual*/

        $articles = array();    /*Array que contendrá los IDs de los artículos pedidos por el usuario actual*/

        foreach($ordersByUser as $orderByUser){   /*Aquí obtenemos los IDs de los artículos que han sido pedidos por el usuario de la sesión actual y serán utilizados para las recomendaciones*/
            foreach(OrderedArticle::where('order_id', $orderByUser->id)->get() as $article){
                $articles[] = $article->article_id;
            }
        }

        $articlesIdOrderedByUser = array_unique($articles); /*Ya tenemos el vector con los IDs de los artículos pedidos por el usuario, sólo queda eliminar las instancias duplicadas de dichos IDs, para ello usamos array_unique()*/

        $articlesOrderedByUser = Article::wherein('id', $articlesIdOrderedByUser)->get(); /*Sacamos las instancias (filas) de los articulos pedidos por el usuario de la tabla articles (filtrando por los Ids obtenidos arriba)*/

        $articlesDB = Article::all(); 

        $articlesMatrix = Article::generateArticlesMatrix(); 

        $articleSimilarity = new ContentBasedFiltering($articlesMatrix);
        $similarityMatrix  = $articleSimilarity->calculateSimilarityMatrix();

        /*Ahora vamos a comparar cada artículo comprado por el usuario con el resto de artículos de la BD para obtener los artículos más recomendados/similares*/
        $recommendedArticlesByPurchases = array();

        foreach($articlesIdOrderedByUser as $articleIdOrderedByUser){
        	$recommendedArticlesByPurchases   = $articleSimilarity->getArticlesSortedBySimilarity($articleIdOrderedByUser, $similarityMatrix);
        }
        return $recommendedArticlesByPurchases;
    }
}
?>