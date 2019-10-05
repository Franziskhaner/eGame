<?php

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

/* Ruta welcome por defecto
Route::get('/', function () {
    return view('welcome');
});
*/


//Rutas del proyecto eGame:
/*
Route::group(['middleware' => 'auth'], function(){

});
*/

Route::get('/', 'MainController@home')->name('home');

Route::get('/search', 'MainController@search');

/*Rutas creadas automáticamente al generar las vistas de login y registro con migraciones.*/
Auth::routes();
//Route::get('/home', 'HomeController@index')->name('home');

Route::resource('users', 'UserController');

Route::resource('articles', 'ArticleController'); //Esto equivale a las siguientes rutas:
/*
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

Route::get('/payments/store', 'PaymentController@store'); /*Esta ruta es la que nos devuelve Paypal automáticamente tras aceptar el pago*/

Route::resource('in_shopping_carts', 'InShoppingCartController', ['only' => ['store', 'destroy']
]);
//Esto equivale a las siguientes rutas:
/*
POST /in_shopping_carts => store
DELETE /in_shopping_carts/:id (Destroy)
*/

Route::resource('shopping', 'ShoppingCartController', ['only' => ['show']]);	/*Ruta del link permanente generado tras el pago con PayPal de una compra*/

Route::get('articles/images/{filename}', function($filename){	/*Con esta ruta hacemos que nuestras imágenes de la carpeta storage se vuelquen a la carpeta public() para que sean visibles desde la web.*/
	$path = storage_path("app/images/$filename");/*storage_path es un helper de Laravel que hace referencia a donde está nuestra carpeta de imágenes.*/
	if(!\File::exists($path)) abort (404); //Si la imagen NO existe, se manda un error 404.

	/*Si existe, obtenemos el archivo con get() y el tipo del archivo con mimeType() para luego indicárselo al navegador y que nos abra el visor de imágenes y no el de .PDF por ejemplo.*/
	$file = \File::get($path);

	$type = \File::mimeType($path);

	$response = Response::make($file, 200); //El código 200 indica que todo salió bien.

	$response->header("Content-Type", $type); //Encabezado de la petición.

	return $response;
});

Route::resource('orders', 'OrderController', ['only' => ['index', 'update']]);

Route::get('your_ratings', 'UserController@ratings')->name('user_ratings');

Route::get('your_orders', 'UserController@orders')->name('user_orders');

Route::get('platform/{platform}', 'ArticleController@showByPlatform');

Route::get('account', 'UserController@account')->name('account');

Route::get('profile/{id}/edit', 'UserController@editProfile');