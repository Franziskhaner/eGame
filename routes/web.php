<?php

use App\Article;
use App\CollaborativeFiltering;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'MainController@home')->name('home');

Route::get('/search', 'MainController@search');

Route::get('/advancedSearch', 'MainController@advancedSearch');

Route::post('/admin/{weigths}', 'MainController@update');

Route::get('/recommendations', function(){
	/*Esta ruta sólo será utilizada por el usuario administrador desde el panel Admin para observar las diferencias entre los sistemas de recomendaciones.*/

	$articlesByContentBasedFiltering = Article::filteredByUserPurchases();
    $articlesByCollaborativeFiltering = CollaborativeFiltering::getRecommendations();

    return view('recommended_article.home', compact(['articlesByContentBasedFiltering', 'articlesByCollaborativeFiltering']));
})->name('recommendations');

Route::get('{crud}/crud_search', 'MainController@crudSearch');

/*Ruta creada automáticamente al generar las vistas de login y registro con migraciones.*/
Auth::routes();

Route::resource('users', 'UserController');

Route::resource('ratings', 'RatingController');

Route::resource('articles', 'ArticleController'); /*Al declarar la ruta como Resource, obtenemos el acceso a las siguientes rutas:
GET /articles => index
POST /articles => store
GET /articles/create => Formulario para crear articulo
GET /articles/:id => Mostrar un articulo con ID
GET /articles/:id/edit
PUT/PATCH /articles/:id  (Update)
DELETE /articles/:id (Destroy)
*/

Route::get('/cart', 'ShoppingCartController@index');

Route::post('/cart', 'ShoppingCartController@checkout')->middleware('auth');	/*Con el middleware nos aseguramos de que antes de pagar (al pinchar en el bótón CHECKOUT del carrito) el usuario invitado deberá iniciar sesión.*/
Route::post('/delete_cart_item', 'InShoppingCartController@destroy');

Route::get('/delivery', 'ShoppingCartController@deliveryOptions')->name('delivery')->middleware('auth');

Route::post('/payment_method', 'ShoppingCartController@deliveryOptionsStore')->name('payment_method');

Route::get('/payments/store', 'PaymentController@store'); /*Esta ruta es la que nos devuelve Paypal automáticamente tras aceptar el pago*/

Route::post('/cancel_order/{id}', 'OrderController@cancelOrder');

Route::resource('orders', 'OrderController');

Route::resource('in_shopping_carts', 'InShoppingCartController', ['only' => ['store', 'destroy']]);

Route::resource('shopping', 'OrderController', ['only' => ['show']]);	/*Ruta del link permanente generado tras el pago de una compra*/

Route::get('articles/images/{filename}', function($filename){	/*Con esta ruta hacemos que nuestras imágenes de la carpeta storage se vuelquen a la carpeta public para que sean visibles desde la web.*/

	$path = storage_path("app/images/$filename");/*storage_path es un helper de Laravel que hace referencia a donde está nuestra carpeta de imágenes.*/
	if(!\File::exists($path)) abort (404); //Si la imagen NO existe, se manda un error 404.

	/*Si existe, obtenemos el archivo con get() y el tipo del archivo con mimeType() para luego indicárselo al navegador y que nos abra el visor de imágenes y no el de .PDF por ejemplo.*/
	$file = \File::get($path);

	$type = \File::mimeType($path);

	$response = Response::make($file, 200); //El código 200 indica que todo salió bien.

	$response->header("Content-Type", $type); //Encabezado de la petición.

	return $response;
});

Route::get('your_ratings', 'UserController@userRatings')->name('user_ratings');

Route::get('your_orders', 'UserController@ordersByUser')->name('user_orders');

Route::get('platform/{platform}', 'ArticleController@showByPlatform');

Route::get('account', 'UserController@account')->name('account');

Route::get('profile/{id}/edit', 'UserController@editProfile'); /*Editar perfil de usuario*/

Route::get('rate_your_order/{id}', 'RatingController@rateYourOrder');

Route::get('payment_with_card', 'PaymentController@payWithStripe')->name('stripform');

Route::post('payment_with_card', 'PaymentController@postPaymentWithStripe')->name('paywithstripe');

Route::get('searchYourOrder', 'UserController@searchYourOrder');
