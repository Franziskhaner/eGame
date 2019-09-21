<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\ContentBasedFiltering;
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
class ContentBasedController extends Controller
{
	public function __construct(){
		$this->middleware('auth');
	}

    public function filterById($id){
    		
		$ordersByUser = Order::where('user_id', Auth::user()->id)->get();
    	
		$articles = array();	/*Array que contendrá los IDs de los artículos pedidos por el usuario actual*/

    	foreach($ordersByUser as $orderByUser){	/*Aquí obtenemos los IDs de los artículos que han sido pedidos por el usuario de la sesión actual y serán utilizados para las recomendaciones*/
    		foreach(OrderedArticle::where('order_id', $orderByUser->id)->get() as $article){
    			$articles[] = $article->article_id;
    		}
    	}

		$articles = array_unique($articles); /*Ya tenemos el vector con los IDs de los artículos pedidos por el usuario, sólo queda eliminar las instancias duplicadas de dichos IDs, para ello usamos array_unique()*/

	    /*ESTO SERÍA PARA RECOMENDAR EN BASE A LOS RATINGS HECHOS POR EL USUARIO, ¡¡¡¡¡QUEDA PENDIENTE POR HACER!!!!*/
	    /*
	    foreach($articles as $article){
	    	$rating[$article] = Rating::where('user_id', Auth::user()->id)->where('article', $article)->get()->first();
	    }

	    print_r($ratings);
		*/

		$articlesTotal = Article::wherein('id', $articles)->get(); /*Sacamos las instancias (filas) de los articulos pedidos por el usuario de la tabla articles (filtrando por los Ids obtenidos arriba)*/

		$articlesDB = Article::all();
		
		$articlesAsociative = array ();
		for($i = 0; $i < sizeof($articlesDB); $i++){
			$articlesAsociative[$i] = array(
				'id'       => $articlesDB[$i]->id,
				'name'	   => $articlesDB[$i]->name,
				'price'    => $articlesDB[$i]->price,
				'gender'   => $articlesDB[$i]->gender,
				'platform' => $articlesDB[$i]->platform,
				'extension'=> $articlesDB[$i]->extension
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
    		return 'There aren´t products to recommend';
    	else
    		//return print_r($articles);
    		return view('article.show', compact('article', 'articles'));
    }
}
