<?php

return array(
	# Account credentials from developer portal
	'Account' => array(
		'ClientId' => env('AfnphSHkhvDcPiN_GZwCsWUs9lEkbyOI48GlXOMQw0vHJ3UODuJ9FjSrKuIKdZN-NjVMwcyqtMFGYFg1', ''),
		'ClientSecret' => env('EO_r7aubM-z_3EPw4AV8TQGNyOtVyLAj1a0BFv1NZefXfqaoBbxA_lO0ys_7lrNzBnYFfJ6bVjimGzc8', ''),
		/*'ClientId' => env('PAYPAL_CLIENT_ID', ''),
		'ClientSecret' => env('PAYPAL_CLIENT_SECRET', ''),*/
	),

	# Connection Information
	'Http' => array(
		// 'ConnectionTimeOut' => 30,
		'Retry' => 1,
		//'Proxy' => 'http://[username:password]@hostname[:port][/path]',
	),

	# Service Configuration
	'Service' => array(
		# For integrating with the live endpoint,
		# change the URL to https://api.paypal.com! /*Para enviar las peticiones de cobro en entorno real*/
		'EndPoint' => 'https://api.sandbox.paypal.com', /*Para enviar las peticiones de cobro en modo desarrollador*/
	),


	# Logging Information
	'Log' => array(
		//'LogEnabled' => true,

		# When using a relative path, the log file is created
		# relative to the .php file that is the entry point
		# for this request. You can also provide an absolute
		# path here
		'FileName' => '../PayPal.log', /* Para debugear*/

		# Logging level can be one of FINE, INFO, WARN or ERROR
		# Logging is most verbose in the 'FINE' level and
		# decreases as you proceed towards ERROR
		//'LogLevel' => 'FINE',
	),
);
