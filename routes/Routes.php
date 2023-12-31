<?php
require 'controllers/ControllerAuth.php';
require 'controllers/ControllerUser.php';
require 'controllers/ControllerProduc.php';
require 'controllers/ControllerSocialReasons.php';
require 'controllers/ControllerSendMail.php';
require_once 'response.php';


function validateRoute($request){
	$split = (explode("/", $request));	
	$route = $split[2];
	// siempre que se cree una nueva ruta la debemos agregar en esta seccion
    $rutaspermitidas = [ "auth","user", "userbyid", "socialreason","produc","producbyuser","productype",
	                     "productstate","company","encryptpass","sendmail","dissolveuser", "userbyemail", "userbyphone"];
    $rutaspermitidas = array_map('strtolower', $rutaspermitidas);
    $route = strtolower($route);
    if(! in_array($route, $rutaspermitidas)){
		return false;
	}else{
		return true;
	}
}

function validateAuthorization($token, $request, $expectedUrl) {
	$split = (explode("/", $request));	
	$url = $split[2];
	if($url === $expectedUrl){				
		if (!isset($token) || empty($token)) {
			return response::json('',401);
		}
		$authorization = checkAuthToken($token);				
		if($authorization !== 202){
			return response::json('',401);
		}
		return true;
	}
}


// /////////////////////////////////////////////////////////////////////////////////////////////////////////
// GET handleGetRequest - manejar obtener solicitud
// /////////////////////////////////////////////////////////////////////////////////////////////////////////

function handleGetRequest($request,$token) {
	
	if(validateRoute($request))
	{
		$response=[];	
		$authorization = checkAuthToken($token);
		
		if (strpos($request, '/api/user') !== false) {   

			if (validateAuthorization($token, $request, "user")) {				
				$response = getUsersAllFromDatabase();
				response::json($response,$authorization);
			}
		}

		if (strpos($request, '/api/userbyid') !== false) {   

			if (validateAuthorization($token, $request, "userbyid")) {
				$payload = file_get_contents('php://input'); 
				$params = json_decode($payload);
				$response = getUserByIdFromDatabase($params);	
				response::json($response,$authorization);
			}
		}	

		if (strpos($request, '/api/userbyemail') !== false) {   

			if (validateAuthorization($token, $request, "userbyemail")) {
				$payload = file_get_contents('php://input'); 
				$params = json_decode($payload);
				$response = getUserByEmailFromDatabase($params);	
				response::json($response,$authorization);
			}
		}

		if (strpos($request, '/api/userbyphone') !== false) {   

			if (validateAuthorization($token, $request, "userbyphone")) {
				$payload = file_get_contents('php://input'); 
				$params = json_decode($payload);
				$response = getUserByPhoneFromDatabase($params);	
				response::json($response,$authorization);
			}
		}		

		if (strpos($request, '/api/socialreason') !== false) {   

			if (validateAuthorization($token, $request, "socialreason")) {				
				$response = getAllSocialReasonsFromDatabase();
				response::json($response,$authorization);
			}
		}	

		if (strpos($request, '/api/produc') !== false) {   

			if (validateAuthorization($token, $request, "produc")) {				
				$response = getProducAllFromDatabase();
				response::json($response,$authorization);
			}	
		}
		
		if (strpos($request, '/api/producbyuser') !== false) {   

			if (validateAuthorization($token, $request, "producbyuser")) {
				$payload = file_get_contents('php://input'); 
				$params = json_decode($payload);
				$response = getProducByUserFromDatabase($params);
				response::json($response,$authorization);
			}	
		}

		if (strpos($request, '/api/productype') !== false) {   

			if (validateAuthorization($token, $request, "productype")) {				
				$response = getProducTypeFromDatabase();
				response::json($response,$authorization);
			}
		}

		if (strpos($request, '/api/productstate') !== false) {   

			if (validateAuthorization($token, $request, "productstate")) {				
				$response = getProducEstatusFromDatabase();
				response::json($response,$authorization);
			}	
		}

		if (strpos($request, '/api/company') !== false) {   

			$split = (explode("/", $request));	
			$url = $split[2];
			if($url == "company"){
				$authorization="";
				$response = getCompanyFromDatabase();
				response::json($response,$authorization);
			}
		}

	}else{
		response::json('',501);		
	}	

}

// /////////////////////////////////////////////////////////////////////////////////////////////////////////
// POST handlePostRequest - manejar la solicitud de publicación
// /////////////////////////////////////////////////////////////////////////////////////////////////////////

function handlePostRequest($request,$token) {
	
	if(validateRoute($request))
	{
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

		if ($request === '/api/sendmail') {

			if (validateAuthorization($token, $request, "sendmail")) {	
				$payload = file_get_contents('php://input'); 				
				$params = json_decode($payload);
				$response = SendMail($params);	
				return response::json($response,$authorization);	  
			}
		}	
	
	}else{
		response::json('',501);		
	}	

}

// /////////////////////////////////////////////////////////////////////////////////////////////////////////
// PUT handlePutRequest - manejar la solicitud de modificación
// /////////////////////////////////////////////////////////////////////////////////////////////////////////

function handlePutRequest($request,$token) {
	
	if(validateRoute($request))
	{
		$response=[];	
		$authorization = checkAuthToken($token);

		if ($request === '/api/user') {		

			if (validateAuthorization($token, $request, "user")) {	
				$payload = file_get_contents('php://input'); 
				$params = json_decode($payload);
				$response = updateUserFromDatabase($params);	
				return response::json($response,$authorization);	  
			}
		}

		if ($request === '/api/socialreason') {		

			if (validateAuthorization($token, $request, "socialreason")) {	
				$payload = file_get_contents('php://input'); 
				$params = json_decode($payload);
				$response = updateSocialReasonFromDatabase($params);	
				return response::json($response,$authorization);	  
			}
		}	

		if ($request === '/api/produc') {		

			if (validateAuthorization($token, $request, "produc")) {	
				$payload = file_get_contents('php://input'); 
				$params = json_decode($payload);
				$response = updateProducFromDatabase($params);			
				return response::json($response,$authorization);	  
			}
		}

	}else{
		response::json('',501);		
	}
	
}

// /////////////////////////////////////////////////////////////////////////////////////////////////////////
// DELETE handleDeleteRequest - manejar la solicitud de eliminación
// /////////////////////////////////////////////////////////////////////////////////////////////////////////

function handleDeleteRequest($request,$token) { 

	if(validateRoute($request))
	{
		$response=[];	
		$authorization = checkAuthToken($token);
		$split = (explode("/", $request));	
		$id = $split[3];	

		if (strpos($request, '/api/socialreason') !== false) {	

			if (validateAuthorization($token, $request, "socialreason")) {	
				removeSocialReasonFromDatabase($id);				
				$response["estado"] = "200";
				return response::json($response,$authorization);	
			}	  
		}	

		if (strpos($request, '/api/produc') !== false) {	

			if (validateAuthorization($token, $request, "produc")) {	
				removeProducFromDatabase($id);				
				$response["estado"] = "200";
				return response::json($response,$authorization);	
			}	  
		}	

		if (strpos($request, '/api/dissolveuser') !== false) {	

			if (validateAuthorization($token, $request, "dissolveuser")) {	
				removeUserCompletelyFromDatabase($id);				
				$response["estado"] = "200";
				return response::json($response,$authorization);	
			}	  
		}	
	
	}else{
		response::json('',501);		
	}
	
} 
