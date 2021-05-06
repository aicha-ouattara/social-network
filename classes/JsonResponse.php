<?php

/**
 *
 */
class JsonResponse
{
	private $response = [];

	function __construct($code, $message= null)
	{
		// clear the old headers
		header_remove();
		// set the actual code
		http_response_code($code);
		// set the header to make sure cache is forced
		header("Cache-Control: no-transform,public,max-age=300,s-maxage=900");
		// treat this as json
		header('Content-Type: application/json');
		$status = array(
			200 => 'OK',
			400 => 'Bad Request', 			//La syntaxe de la requête est erronée.
			405 => 'Method Not Allowed',	//Méthode de requête non autorisée.
			401 => 'Unauthorized',			//Une authentification est nécessaire pour accéder à la ressource.
			403 => 'Forbidden',				//l'authentification a été acceptée mais les droits d'accès ne permettent pas au client d'accéder à la ressource.
			404 => 'Not Found',
			422 => 'Unprocessable Entity',
			500 => '500 Internal Server Error'
		);
		// ok, validation error, or failure
		header('Status: '.$status[$code]);
		// return the encoded json
		return json_encode(array(
			'status' => $code < 300, // success or not?
			'message' => $message
		));
	}
}
