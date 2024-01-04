<?php
require 'controllers/ControllerAuth.php';
require 'controllers/ControllerUser.php';
require 'controllers/ControllerProduc.php';
require 'controllers/ControllerSocialReasons.php';
require 'controllers/ControllerSendMail.php';
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
		}else{
			return response::json('',401);
		}		
    }

	if (strpos($request, '/api/socialreason') !== false) {   
		if (validateAuthorization($token, $request, "socialreason")) {				
			$response = getAllSocialReasonsFromDatabase();
		}else{
			return response::json('',401);
		}		
    }	

	if (strpos($request, '/api/produc') !== false) {   
		if (validateAuthorization($token, $request, "produc")) {				
			$response = getProducAllFromDatabase();
		}else{
			return response::json('',401);
		}		
    }
	
	if (strpos($request, '/api/producbyuser') !== false) {   
		if (validateAuthorization($token, $request, "producbyuser")) {
			$payload = file_get_contents('php://input'); 
			$params = json_decode($payload);
			$response = getProducByUserFromDatabase($params);
		}else{
			return response::json('',401);
		}		
    }

	if (strpos($request, '/api/productype') !== false) {   
		if (validateAuthorization($token, $request, "productype")) {				
			$response = getProducTypeFromDatabase();
		}else{
			return response::json('',401);
		}		
    }

	if (strpos($request, '/api/productstate') !== false) {   
		if (validateAuthorization($token, $request, "productstate")) {				
			$response = getProducEstatusFromDatabase();
		}else{
			return response::json('',401);
		}		
    }

	if (strpos($request, '/api/company') !== false) {   
		$split = (explode("/", $request));	
		$url = $split[2];	
		if($url == "company"){
			$authorization="";
			$response = getCompanyFromDatabase();
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
			$company = $_POST['company'];
			$response = getUsersAuthenticate($user,$pass, $company);
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
		$split = (explode("/", $request));	
		$url = $split[2];	
		if($url == "user"){		
			$payload = file_get_contents('php://input'); 				
			$params = json_decode($payload);
			$response = saveUserFromDatabase($params);	
			return response::json($response);	  
		}
	}		

	if ($request === '/api/socialreason') {
		if (validateAuthorization($token, $request, "socialreason")) {	
			$payload = file_get_contents('php://input'); 				
			$params = json_decode($payload);
			$response = saveSocialReasonFromDatabase($params);	
			return response::json($response,$authorization);	  
		}else{
			return response::json('',401);
		}
	}	

	if ($request === '/api/produc') {
		if (validateAuthorization($token, $request, "produc")) {	
			$payload = file_get_contents('php://input'); 				
			$params = json_decode($payload);
			$response = saveProducFromDatabase($params);	
			return response::json($response,$authorization);	  
		}else{
			return response::json('',401);
		}
	}

	if ($request === '/api/sendmail') {
		if (validateAuthorization($token, $request, "sendmail")) {	
			$payload = file_get_contents('php://input'); 				
			$params = json_decode($payload);
			$response = SendMail($params);	
			return response::json($response,$authorization);	  
		}else{
			return response::json('',401);
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
		}else{
			return response::json('',401);
		}
    }

    if ($request === '/api/socialreason') {		
		if (validateAuthorization($token, $request, "socialreason")) {	
			$payload = file_get_contents('php://input'); 
			$params = json_decode($payload);
			$response = updateSocialReasonFromDatabase($params);	
		}else{
			return response::json('',401);
		}
    }	

    if ($request === '/api/produc') {		
		if (validateAuthorization($token, $request, "produc")) {	
			$payload = file_get_contents('php://input'); 
			$params = json_decode($payload);
			$response = updateProducFromDatabase($params);				
		}else{
			return response::json('',401);
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
		}else{
			return response::json('',401);
		}		  
    }	

	if (strpos($request, '/api/produc') !== false) {						
		if (validateAuthorization($token, $request, "produc")) {	
			removeProducFromDatabase($id);				
			$response["estado"] = "200";
		}else{
			return response::json('',401);
		}		  
    }	

	if (strpos($request, '/api/dissolveuser') !== false) {						
		if (validateAuthorization($token, $request, "dissolveuser")) {	
			removeUserCompletelyFromDatabase($id);				
			$response["estado"] = "200";
		}else{
			return response::json('',401);
		}		  
    }	

	return response::json($response,$authorization);	
} 
