<?php
/*Con este fichero vamos a definir toda la configuración necesaria para realizar las peticiones de pago a Paypal (indicar quién realiza el pago, si tenemos permisos, etc)*/
namespace App;

class PayPal
{
	private $_apiContext;
	private $shopping_cart;	/*Carrito que estamos intentando cobrar*/
	private $_ClientId = 'AfnphSHkhvDcPiN_GZwCsWUs9lEkbyOI48GlXOMQw0vHJ3UODuJ9FjSrKuIKdZN-NjVMwcyqtMFGYFg1';
	private $_ClientSecret = 'EO_r7aubM-z_3EPw4AV8TQGNyOtVyLAj1a0BFv1NZefXfqaoBbxA_lO0ys_7lrNzBnYFfJ6bVjimGzc8';

	public function __construct($shopping_cart){

		$this->_apiContext = \PaypalPayment::ApiContext($this->_ClientId, $this->_ClientSecret); /*PaypalPayment es la librería de la cual nos vamos a servir para utilizar los métodos necesarios para los pagos/cobros*/

		$config = config("paypal_payment"); /*Nombre del archivo donde tenemos la configuración (C:\wamp64\www\eGame\config)*/
		
		$flatConfig = array_dot($config);/*Con array_dot convertimos la información que hay en la variable $config en el formato necesario para que lo reciba el método .setConfig() a continuación*/

		$this->_apiContext->setConfig($flatConfig);

		$this->shopping_cart = $shopping_cart;
	}

	/*El método generate() es llamado desde el controlador ShoppingCartController para generar el cobro*/
	public function generate(){
		$payment = \PaypalPayment::payment()->setIntent('sale')
		->setPayer($this->payer())
		->setTransactions([$this->transaction()])
		->setRedirectUrls($this->redirectURLs());
		/* setIntent() nos indica cual es el objetivo de esta operación, en este caso es vender ('sale')*/

		try{
			$payment->create($this->_apiContext);
		} catch(\Exception $ex){
			dd($ex);
			exit(1);
		}

		return $payment;
	}

	/* Con Payer() devolvemos la información del pagador y nos permite realizar los cobros con tarjeta, indicando todos los datos de la misma (numero, fecha caducidad, código secreto, etc) pero en esta ocasión sólo definimos los pagos vía PayPal*/
	public function payer(){
		//Returns payment's info
		return \PaypalPayment::payer()->setPaymentMethod('paypal'); /*En el caso de cobro con Paypal solo hay que indicar que el método de pago es vía Paypal, con éste método indicaríamos los datos del cobro con tarjeta */
	}

	public function redirectURLs(){
		//Returns transaction's URLs
		$baseURL = url('/');

		return \PaypalPayment::redirectUrls()
								->setReturnUrl("$baseURL/payments/store")
								->setCancelUrl("$baseURL/cart");
		/*Aquí vamos a redireccionar al usuario a una URL u otra en función de si el pago se procesó con éxito o no*/
	}

	public function transaction(){
		//Returns transaction's info (toda la info que necesita PayPal para procesar las peticiones)

		return \PaypalPayment::transaction()
				->setAmount($this->amount())
				->setItemList($this->items())
				->setDescription('Your shopping in eGame')
				->setInvoiceNumber(uniqid()); /*InvoiceNumber sería como el identificador del cobro, le mandamos uniqid() que genera un ID único de tipo string basado en la hora actual*/
	}

	public function items(){
		//Obtenemos los artículos del carrito de la compra y los añadimos al array item ya que es el formato que acepta Paypal

		$items = [];

		$articles = $this->shopping_cart->articles()->get();

		foreach ($articles as $article){
			array_push($items, $article->paypalItem());
		}/*paypalItem() está definido en el modelo Article.php y nos devuelve toda la info del carrito de la compra además de otros datos que necesita Paypal*/

		return \PaypalPayment::itemList()->setItems($items);
	}

	public function amount(){
		return \PaypalPayment::amount()->setCurrency('EUR')->setTotal($this->shopping_cart->totalEUR());
		/*Aquí indicamos la moneda que va a procesarse en el cobro, si quisiéramos utilizar otra distinta a las que soportan la API de PayPal habría que utilizar el método setTotal() para realizar nuestra conversión manual*/
	}

	public function execute($paymentId, $payerId){
		$payment = \PaypalPayment::getById($paymentId, $this->_apiContext); /*paymenId contiene el ID del pago en PayPal, y payerId el ID del usuario comprador o al que se le va a realizar el cobro*/

		$execution = \PaypalPayment::PaymentExecution()->setPayerId($payerId);

		 return $payment->execute($execution, $this->_apiContext); /*Este execute es de la API de PayPal y es el que ejecuta el cobro*/
	}
}