<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

use Auth;
use App\Order;
use App\Rating;
use App\Article;
use App\ShoppingCart;
use App\InShoppingCart;
use App\OrderedArticle;
use App\RecommendationsSystemWeigth;

class Article extends Model
{
	protected $table = 'articles';

	//Agregamos los datos de la tabla
	protected $fillable =['id', 'name', 'price', 'quantity', 'release_date', 'players_num', 'gender', 'platform', 'description', 'assessment'];

    //Query Scopes:
	public function scopeLatest($query){	//Nos va a devolver los últimos productos.
		return $query->orderBy('id', 'asc');
	}

    public function scopeName($query, $name){
        if($name)
            return $query->where('name', 'like', '%'.$name.'%');
    }

    public function scopePlatform($query, $platform){
        if($platform)
            return $query->where('platform', 'like', '%'.$platform.'%');
    }

    public function scopeGender($query, $gender){
        if($gender)
            return $query->where('gender', 'like', '%'.$gender.'%');
    }

    public function scopePrice($query, $price){
        switch ($price) {
            case 'Minus 10€':
                return $query->where('price', '<', 10);
                break;
            case '10€ - 20€':
                return $query->whereBetween('price', [10, 20]);
                break;
            case '20€ - 30€':
                return $query->whereBetween('price', [20, 30]);
                break;
            case '30€ - 40€':
                return $query->whereBetween('price', [30, 40]);
                break;
            case '40€ - 50€':
                return $query->whereBetween('price', [40, 50]);
                break;
            case '50€ - 60€':
                return $query->whereBetween('price', [50, 60]);
                break;
            case 'More 60€':
                return $query->where('price', '>', 60);
                break;
            default:
                return 0;
                break;
        }
    }

    public function scopeReleaseDate($query, $releaseDate){
        if($releaseDate)
            return $query->where('release_date', 'like', '%'.$releaseDate.'%');
    }

	public function paypalItem(){ //Es llamada desde el modelo PayPal.php para indicar a Paypal toda la info de nuestro carrito.
		
		$shopping_cart_id  = ShoppingCart::where('user_id', Auth::user()->id)->get()->last()->id; //Obtenemos el id del carrito del usuario con sesión actual.
		$in_shopping_carts = InShoppingCart::get()->where('shopping_cart_id', $shopping_cart_id);//Con ese id sacamos todas las istancias del carrito actual
		
		$in_shopping_cart_article_quantity = $in_shopping_carts->where('article_id', $this->id)->first()->quantity;	//Finalmente obtenemos la instancia del articulo actual y nos quedamos con las cantidades del mismo para pasársela al método item() de PaypalPayment:
	
		return \PaypalPayment::item()->setName($this->name)
					->setDescription($this->description)
					->setCurrency('EUR')
					->setQuantity($in_shopping_cart_article_quantity)
					->setPrice($this->price / 100);
	}

	public static function generateArticlesMatrix(){ /*Este método generará una matriz compuesta de arrays asociativos con los atributos necesarios por cada artículo de la Base de Datos. Esta matriz se utilizará para calcular los artículos similares posteriormente*/
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

        $articlesMatrix = Article::generateArticlesMatrix(); 
        $articleSimilarity = new ContentBasedFiltering($articlesMatrix);

        /*Una vez generado nuestro objeto ContentBasedFiltering, llamamos a los métodos seteadores de los pesos, para pasarles los valores introducidos por el usuario administrador, y poder así, mostrar comparativas entre las recomendaciones:*/

        $articleSimilarity->setPriceWeight(RecommendationsSystemWeigth::first()->price);
        $articleSimilarity->setGenderWeight(RecommendationsSystemWeigth::first()->gender);
        $articleSimilarity->setPlatformWeight(RecommendationsSystemWeigth::first()->platform);

        /*Una vez seteados los pesos, llamamos a la función que se encarga de calcular la matriz de similitud de los artículos:*/

        $similarityMatrix = $articleSimilarity->calculateSimilarityMatrix();
        
        /*Y por último, ordenamos la matriz de similuitudes pasándole el id del artículo indicado en la URL para hacer las recomendaciones en base a él*/

        $articlesSortedBySimilarity = $articleSimilarity->getArticlesSortedBySimilarity($id, $similarityMatrix);

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

        $articlesOrderedByUser = Article::wherein('id', $articlesIdOrderedByUser)->get(); /*Sacamos las instancias (filas) de los artículos pedidos por el usuario de la tabla articles (filtrando por los Ids obtenidos arriba)*/

        $articlesDB = Article::all(); 

        $articlesMatrix = Article::generateArticlesMatrix(); 

        $articleSimilarity = new ContentBasedFiltering($articlesMatrix);

        /*A continuación, llamamos a los métodos seteadores de los pesos, para pasarles los valores introducidos por el usuario administrador, para poder realizar pruebas y comparaciones:*/

        $articleSimilarity->setPriceWeight(RecommendationsSystemWeigth::first()->price);
        $articleSimilarity->setGenderWeight(RecommendationsSystemWeigth::first()->gender);
        $articleSimilarity->setPlatformWeight(RecommendationsSystemWeigth::first()->platform);

        /*Una vez seteados los pesos, llamamos a la función que se encarga de calcular la matriz de similitud de los artículos:*/

        $similarityMatrix  = $articleSimilarity->calculateSimilarityMatrix();

        /*Ahora vamos a comparar cada artículo comprado por el usuario con el resto de artículos de la BD para obtener los artículos más recomendados/similares según las compras realizadas:*/
        $recommendedArticlesByPurchases = array();

        foreach($articlesIdOrderedByUser as $articleIdOrderedByUser){
        	$recommendedArticlesByPurchases   = $articleSimilarity->getArticlesSortedBySimilarity($articleIdOrderedByUser, $similarityMatrix);
        }

        return $recommendedArticlesByPurchases;
    }

    public static function bestSellers(){
        /*Con el método orderedArticleCount() contamos el número de veces que ha sido comprado cada artículo y lo almacenamos en el campo 'purchasesNum' del array asociativo $bestSellers, lo hacemos así para luego poder ordenarlo por el número de compras (clave purchasesNum), ya que desde un objeto Eloquent no podemos hacerlo.*/

        $articles = Article::all();

        for($i = 0; $i < sizeof($articles); $i++){
            $bestSellers[$i] = array(
                'id'           => $articles[$i]->id,
                'name'         => $articles[$i]->name,
                'price'        => $articles[$i]->price,
                'gender'       => $articles[$i]->gender,
                'platform'     => $articles[$i]->platform,
                'quantity'     => $articles[$i]->quantity,
                'extension'    => $articles[$i]->extension,
                'assessment'   => $articles[$i]->assessment,
                'players_num'  => $articles[$i]->players_num,
                'release_date' => $articles[$i]->release_date,
                'purchasesNum' => OrderedArticle::orderedArticleCount($articles[$i]->id)
            );
        }

        /*Por último, devolvemos el array ordenado según el número de compras(o ventas) de dicho artículo:*/
        $bestSellers = collect($bestSellers)->sortBy('purchasesNum')->reverse()->toArray();

        return  $bestSellers;
    }

    public static function bestRated(){
        return Article::orderBy('assessment', 'desc')->limit(6)->get();
    }
}
?>