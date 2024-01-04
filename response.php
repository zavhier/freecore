<?php

/*
@Response: El propósito de esta lección es proporcionar respuestas con un formato estandarizado 
           para mejorar la integración y la comunicación entre el backend y el frontend. 
*/

class response {

    const HTTP_200_SUCCESS = 'HTTP_200_SUCCESS: Solicitud ha tenido éxito';
    const HTTP_401_UNAUTHORIZED = 'HTTP_401_UNAUTHORIZED: Es necesario autenticar para obtener la respuesta solicitada';
    const HTTP_404_NOT_FOUND = 'HTTP_404_NOT_FOUND: El servidor no pudo encontrar el contenido solicitado';
	const HTTP_501_NOT_FOUND = 'HTTP_501_NOT_FOUND: El servidor no pudo encontrar la ruta solicitada';

    private static function generateUnauthorizedResponse() {
		header('Content-Type: application/json; charset=utf-8');
		return '{"data": [], "total": 0, "estado": 401, "detalle": "'. response::HTTP_401_UNAUTHORIZED.'"}';
    }

	private static function generateInvalidRouteResponse() {
		header('Content-Type: application/json; charset=utf-8');
		return '{"data": [], "total": 0, "estado": 501, "detalle": "'. response::HTTP_501_NOT_FOUND.'"}';
    }

    private static function generateResponse($response) {
		$count = count($response);			
		if($_SERVER['REQUEST_METHOD'] == 'POST' or $_SERVER['REQUEST_METHOD'] == 'PUT' or $_SERVER['REQUEST_METHOD'] == 'DELETE'){
			$count = 1;
		}
		if(isset($response['estado']) and ($response['estado'] == 401 or $response['estado'] == 404 )){
			$count = 0;
		}
		$arrayassoc = ['data' => $response, 'total' => $count, 
		    'estado' => $count > 0 ? 200 : 404, 'detalle' => $count > 0 ? self::HTTP_200_SUCCESS : self::HTTP_404_NOT_FOUND];
		header('Content-Type: application/json; charset=utf-8');
		return json_encode($arrayassoc);
    }	

    public static function json($response,$authorization='') {
		if ($authorization == 401) {
			echo self::generateUnauthorizedResponse();
		}
		elseif ($authorization == 501) {
			echo self::generateInvalidRouteResponse();
		}		
		else{
			echo self::generateResponse($response);
		}
    }	   
}

?>