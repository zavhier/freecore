<?php

require_once 'db.php';


function getUsersAuthenticate($email,$pass, $idempresa){

    $user = array();    
    $db = new ConnectionDatabase();
    $query = "SELECT * FROM usuarios WHERE (email = ? AND idempresa = ?)";

    $resultset = $db->runQuery($query,'ss',$param_value_array=[$email, $idempresa]);   	

    if($resultset && isset($email) && isset($pass) && password_verify($pass, $resultset[0]["password"])){        
        $user["mensaje"]='Usuario autentificado con exito';
        $user["estado"]="200";
        $user["access_token"]=generarToken($resultset[0]['id'],$resultset[0]['email'],$resultset[0]['rol']);
        $user["idusuario"]=$resultset[0]['id']; 
		$user["idempresa"]=$resultset[0]['idempresa']; 
        $user["rol"]=$resultset[0]['rol']; 
    }else{
		$user["mensaje"]='Usuario no autentificado';
		if(!isset($idempresa)){
			$user["mensaje"]='Faltan datos requeridos para autentificar. No se ha proporcionado id de la compañia.';
		}        
        $user["estado"]="401";
        $user["access_token"]='';
        $user["idusuario"]=''; 
    }
	$db->close();	
	
    return $user;
}

function generarToken($userID, $username, $rol) {
	
	$secretKey = 'amTbcjulkbn0';
	
    // Configuración del encabezado
    $header = [
        'alg' => 'HS256',
        'typ' => 'JWT'
    ];

    if(empty($rol) || !isset($rol)) {
        $rol = 'user';
    }

    // Configuración del payload
    $expiracion = time() + (8 * 60 * 60); // Expira en 8 horas
    $payload = [
        'IDUser' => $userID,
        'NombreUsuario' => $username,
        'exp' => $expiracion,
        'rol' => $rol
    ];

    // Codificación Base64 de los componentes del token
    $headerBase64 = base64_encode(json_encode($header));
    $payloadBase64 = base64_encode(json_encode($payload));

    // Crear la firma del token    
    $firma = hash_hmac('sha256', "$headerBase64.$payloadBase64", $secretKey, true);
    $firmaBase64 = base64_encode($firma);

    // Construir el token completo
    $token = "$headerBase64.$payloadBase64.$firmaBase64";

    return $token;
}

function checkAuthToken($token) {

    $secretKey = 'amTbcjulkbn0';
    $algorithm = 'sha256'; // O el algoritmo que estés utilizando

    // Cuando un cliente me envía su token, debo verificar si ese token es válido y además,
    // si no ha expirado. Al token recibido lo desencripto y recupero el nombre de usuario.
    $token = str_replace('Bearer ', '', $token);
    $tokenParts = explode('.', $token);

    if (count($tokenParts) !== 3) {
        return 401; // Token inválido
    }

    list($header, $payload, $signature) = $tokenParts;

    $decodedHeader = json_decode(base64_decode($header));
    $decodedPayload = json_decode(base64_decode($payload));

    if (!$decodedHeader->{'alg'} || !$decodedPayload->{'IDUser'}) {
        return 401; // Token inválido
    }

    $dataToVerify = "$header.$payload";
    $signatureProvided = base64_decode($signature);

    // Verificar la firma

    $validSignature = hash_hmac($algorithm, $dataToVerify, $secretKey, true);

    if (!$validSignature || !hash_equals($signatureProvided, $validSignature)) {
        return 401; // Firma inválida
    }

    // Verificar la expiración
    $currentTimestamp = time();

    if (isset($decodedPayload->exp) && $decodedPayload->exp < $currentTimestamp) {
        return 401; // Token expirado
    }

    // Obtener el nombre de usuario
    $username = $decodedPayload->NombreUsuario;

    if ($username === null) {
        return 401;
    }

    return 202;
}

function getPasswordEncrypt($password){    
    $response = [];
    $opciones = ['cost' => 12];
    $passwordHash = password_hash($password, PASSWORD_BCRYPT, $opciones);  
    if(!empty($passwordHash)){
        $response["mensaje"]='Clave encriptada con exito.';
        $response["password"]=$passwordHash;
        $response["estado"]="200";    
    }else{
        $response["mensaje"]='Error al intentar encriptar la clave de usuario.';
        $response["password"]="";
        $response["estado"]="404";    
    }
    
    return $response;
}

