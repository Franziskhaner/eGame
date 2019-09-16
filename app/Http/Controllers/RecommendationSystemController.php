<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\ArticleSimilarity;
use App\OrderedArticle;
use App\Order;
use App\Article;
use Auth;

/*Este controlador está basado en la siguiente ruta: */
/*
Route::get('/', function () {
    $products        = json_decode(file_get_contents(storage_path('data/products-data.json')));
    $selectedId      = intval(app('request')->input('id') ?? '8');
    $selectedProduct = $products[0];
    $selectedProducts = array_filter($products, function ($product) use ($selectedId) { return $product->id === $selectedId; });
    if (count($selectedProducts)) {
        $selectedProduct = $selectedProducts[array_keys($selectedProducts)[0]];
    }
    $productSimilarity = new App\ProductSimilarity($products);
    $similarityMatrix  = $productSimilarity->calculateSimilarityMatrix();
    $products          = $productSimilarity->getProductsSortedBySimularity($selectedId, $similarityMatrix);
    return view('welcome', compact('selectedId', 'selectedProduct', 'products'));
});
*/
class RecommendationSystemController extends Controller
{
	public function __construct(){
		$this->middleware('auth');
	}

    public function basedContent($id){

		$ordersByUsers = Order::where('user_id', Auth::user()->id)->get();
    	
		$articles = array();	/*Array que contendrá los IDs de los artículos pedidos por el usuario actual*/

    	foreach($ordersByUsers as $ordersByUser){	/*Aquí obtenemos los IDs de los artículos que han sido pedidos por el usuario de la sesión actual y serán utilizados para las recomendaciones*/
    		foreach(OrderedArticle::where('order_id', $ordersByUser->id)->get() as $article){
    			$articles[] = $article->article_id;
    		}
    	}

		$articles = array_unique($articles); /*Ya tenemos el vector con los IDs de los artículos pedidos por el usuario, sólo queda eliminar las instancias duplicadas de dichos IDs, para ello usamos array_unique()*/

	    /*ESTO SERÍA PARA RECOMENDAR EN BASE A LOS RATINGS HECHO POR EL USUARIO, ¡¡¡¡¡QUEDA PENDIENTE POR HACER!!!!*/
	    /*
	    foreach($articles as $article){
	    	$rating[$article] = Rating::where('user_id', Auth::user()->id)->where('article', $article)->get()->first();
	    }

	    print_r($ratings);
		*/

		$articlesTotal = Article::wherein('id', $articles)->get(); /*Con esto sacamos las instancias (filas) de los articulos pedidos por el usuario de la tabla articles (filtrando por los Ids obtenidos arriba)*/

		$articlesBD = Article::all();
		
		$articlesAsociative = array ();
		for($i = 0; $i < sizeof($articlesBD); $i++){
			$articlesAsociative[$i] = array(
				'id'       => $articlesBD[$i]->id,
				'name'	   => $articlesBD[$i]->name,
				'price'    => $articlesBD[$i]->price,
				'gender'   => $articlesBD[$i]->gender,
				'platform' => $articlesBD[$i]->platform,
				'extension'=> $articlesBD[$i]->extension
			);
		}

		$article=Article::find($id);	/*Pasamos el artículo indicado en la URL para hacer las recomendaciones en base a él*/

	    $articleSimilarity = new ArticleSimilarity($articlesAsociative);
	    $similarityMatrix  = $articleSimilarity->calculateSimilarityMatrix();
	    $articles          = $articleSimilarity->getArticlesSortedBySimilarity($article->id, $similarityMatrix);

	    /*
		echo 'ARTICULO SELECCIONADO'.$article.'MATRIZ SIMILARES:';
		print_r($articles);
		*/

	    if(sizeof($articles) == 0)
    		return 'No hay nada para recomendar';
    	else
    		//return print_r($articles);
    		return view('article.show', compact('article', 'articles'));
    }
}
