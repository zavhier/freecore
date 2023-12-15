<?php
require 'controllers/ControllerAuth.php';
require 'controllers/ControllerUser.php';
require 'controllers/ControllerProduc.php';
require 'controllers/ControllerSocialReasons.php';
require 'controllers/ControllerQRCode.php';
require_once 'response.php';

function validateAuthorization($token, $request, $expectedUrl) {
	$split = (explode("/", $request));	
	$url = $split[2];
    if (!isset($token) || empty($token) || ($url !== $expectedUrl)  ) {
        return false;
    }
	$authorization = checkAuthToken($token);
	if($authorization !== 202){
		return false;
	}
    return true;
}


// /////////////////////////////////////////////////////////////////////////////////////////////////////////
// GET handleGetRequest - manejar obtener solicitud
// /////////////////////////////////////////////////////////////////////////////////////////////////////////

function handleGetRequest($request,$token) {
	
	$response=[];	
	$authorization = checkAuthToken($token);
	
	if (strpos($request, '/api/user') !== false) {   
		if (validateAuthorization($token, $request, "user")) {				
			$response = getUsersAllFromDatabase();
		}		
    }

	if (strpos($request, '/api/socialreason') !== false) {   
		if (validateAuthorization($token, $request, "socialreason")) {				
			$response = getAllSocialReasonsFromDatabase();
		}		
    }	

	if (strpos($request, '/api/produc') !== false) {   
		if (validateAuthorization($token, $request, "produc")) {				
			$response = getProducAllFromDatabase();
		}		
    }
		
	response::json($response,$authorization);	
}

// /////////////////////////////////////////////////////////////////////////////////////////////////////////
// POST handlePostRequest - manejar la solicitud de publicación
// /////////////////////////////////////////////////////////////////////////////////////////////////////////

function handlePostRequest($request,$token) {
	
	$response=[];	
	$authorization = checkAuthToken($token);

	if ($request === '/api/auth') {	
		$split = (explode("/", $request));	
		$url = $split[2];	
		if($url == "auth"){
			$user = $_POST['username'];
			$pass = $_POST['password'];
			$response = getUsersAuthenticate($user,$pass);
			return response::json($response);	  
		}
	}	

	if ($request === '/api/encryptpass') {	
		$split = (explode("/", $request));	
		$url = $split[2];	
		if($url == "encryptpass"){
			$pass = $_POST['password'];
			$response = getPasswordEncrypt($pass);
			return response::json($response);	  
		}
	}		

	if ($request === '/api/user') {
		if (validateAuthorization($token, $request, "user")) {	
			$payload = file_get_contents('php://input'); 				
			$params = json_decode($payload);
			$response = saveUserFromDatabase($params);	
			return response::json($response,$authorization);	  
		}
	}		

	if ($request === '/api/socialreason') {
		if (validateAuthorization($token, $request, "socialreason")) {	
			$payload = file_get_contents('php://input'); 				
			$params = json_decode($payload);
			$response = saveSocialReasonFromDatabase($params);	
			return response::json($response,$authorization);	  
		}
	}	

	if ($request === '/api/produc') {
		if (validateAuthorization($token, $request, "produc")) {	
			$payload = file_get_contents('php://input'); 				
			$params = json_decode($payload);
			$response = saveProducFromDatabase($params);	
			return response::json($response,$authorization);	  
		}
	}
	
}

// /////////////////////////////////////////////////////////////////////////////////////////////////////////
// PUT handlePutRequest - manejar la solicitud de modificación
// /////////////////////////////////////////////////////////////////////////////////////////////////////////

function handlePutRequest($request,$token) {

	$response=[];	
	$authorization = checkAuthToken($token);

    if ($request === '/api/user') {		
		if (validateAuthorization($token, $request, "user")) {	
			$payload = file_get_contents('php://input'); 
			$params = json_decode($payload);
			$response = updateUserFromDatabase($params);	
		}
    }

    if ($request === '/api/socialreason') {		
		if (validateAuthorization($token, $request, "socialreason")) {	
			$payload = file_get_contents('php://input'); 
			$params = json_decode($payload);
			$response = updateSocialReasonFromDatabase($params);	
		}
    }	

    if ($request === '/api/produc') {		
		if (validateAuthorization($token, $request, "produc")) {	
			$payload = file_get_contents('php://input'); 
			$params = json_decode($payload);
			$response = updateProducFromDatabase($params);				
		}
    }

	return response::json($response,$authorization);	  
}

// /////////////////////////////////////////////////////////////////////////////////////////////////////////
// DELETE handleDeleteRequest - manejar la solicitud de eliminación
// /////////////////////////////////////////////////////////////////////////////////////////////////////////

function handleDeleteRequest($request,$token) { 

	$response=[];	
	$authorization = checkAuthToken($token);
	$split = (explode("/", $request));	
	$id = $split[3];	

	if (strpos($request, '/api/socialreason') !== false) {						
		if (validateAuthorization($token, $request, "socialreason")) {	
			removeSocialReasonFromDatabase($id);				
			$response["estado"] = "200";
		}		  
    }	

	if (strpos($request, '/api/produc') !== false) {						
		if (validateAuthorization($token, $request, "produc")) {	
			removeProducFromDatabase($id);				
			$response["estado"] = "200";
		}		  
    }	

	if (strpos($request, '/api/dissolveuser') !== false) {						
		if (validateAuthorization($token, $request, "dissolveuser")) {	
			removeUserCompletelyFromDatabase($id);				
			$response["estado"] = "200";
		}		  
    }	

	return response::json($response,$authorization);	
} 
