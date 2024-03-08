<?php
require 'controllers/ControllerAuth.php';
require 'controllers/ControllerUser.php';
require 'controllers/ControllerProduc.php';
require 'controllers/ControllerSocialReasons.php';
require 'controllers/ControllerSendMail.php';
require 'controllers/ControllerLogsApp.php';
require_once 'response.php';


function validateRoute($request){
	$split = (explode("/", $request));	
	$route = $split[2];
	// siempre que se cree una nueva ruta la debemos agregar en esta seccion
    $rutaspermitidas = [ "auth","user", "userbyid", "dissolveuser", "userbyemail", "userbyphone","recoveruser","checkexistsuser",
						 "socialreason", "socialreasonbyid", "socialreasonbyname",  
						 "produc","producbyuser","productype","productstate","productbyqrcode", "producbystate","productbysocialreason", "productsuploadqr","producbycondition",
						 "company","encryptpass","sendmail", "writetotogfile"
						];
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
		
		$split = (explode("/", $request));	
		$url = $split[2];
		$param = $split[3];	

		if (strpos($request, '/api/user') !== false) {   

			if (validateAuthorization($token, $request, "user")) {				
				$response = getUsersAllFromDatabase();
				response::json($response,$authorization);
			}
		}

		if (strpos($request, '/api/userbyid') !== false) {   

			if (validateAuthorization($token, $request, "userbyid")) {
				$response = getUserByIdFromDatabase($param);	
				response::json($response,$authorization);
			}
		}	

		if (strpos($request, '/api/userbyphone') !== false) {   

			if (validateAuthorization($token, $request, "userbyphone")) {
				$response = getUserByPhoneFromDatabase($param);	
				response::json($response,$authorization);
			}
		}		

		if (strpos($request, '/api/socialreason') !== false) {   

			if (validateAuthorization($token, $request, "socialreason")) {				
				$response = getAllSocialReasonsFromDatabase();
				response::json($response,$authorization);
			}
		}	

		if (strpos($request, '/api/socialreasonbyid') !== false) {   

			if (validateAuthorization($token, $request, "socialreasonbyid")) {				
				$response = getSocialReasonsByIdFromDatabase($param);
				response::json($response,$authorization);
			}
		}			
		
		if (strpos($request, '/api/socialreasonbyname') !== false) {   

			if (validateAuthorization($token, $request, "socialreasonbyname")) {	
				$response = getSocialReasonsByNameFromDatabase($param);
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
				$response = getProducByUserFromDatabase($param);
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

		if (strpos($request, '/api/productbyqrcode') !== false) {   

			if($url == "productbyqrcode"){			
				$response = getProducByQrCodeFromDatabase($param);
				response::json($response);
			}	
		}
		
		if (strpos($request, '/api/productbysocialreason') !== false) {   

			if (validateAuthorization($token, $request, "productbysocialreason")) {				
				$response = getProducByIdSocialReasonFromDatabase($param);
				response::json($response,$authorization);
			}	
		}

		if (strpos($request, '/api/company') !== false) {   

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
		$split = (explode("/", $request));	
		$url = $split[2];	

		if ($request === '/api/auth') {	

			if($url == "auth"){
				$user = $_POST['username'];
				$pass = $_POST['password'];
				$company = $_POST['company'];
				$response = getUsersAuthenticate($user,$pass, $company);
				return response::json($response); 
			}
		}	

		// if ($request === '/api/encryptpass') {	

		// 	if($url == "encryptpass"){
		// 		$pass = $_POST['password'];
		// 		$response = getPasswordEncrypt($pass);
		// 		return response::json($response);	  
		// 	}
		// }		

		if ($request === '/api/user') {
			
			if($url == "user"){		
				$payload = file_get_contents('php://input'); 				
				$params = json_decode($payload);
				$response = saveUserFromDatabase($params);	
				return response::json($response);	  
			}
		}		

		if (strpos($request, '/api/checkexistsuser') !== false) {   

			if($url == "checkexistsuser"){	
				$payload = file_get_contents('php://input'); 				
				$params = json_decode($payload);				
				$response = checkexistsuserByEmailFromDatabase($params);	
				response::json($response);
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

		if ($request === '/api/productsuploadqr') {

			if (validateAuthorization($token, $request, "productsuploadqr")) {	
				$payload = file_get_contents('php://input'); 				
				$params = json_decode($payload);
				$response = saveProducBarcodeQrFromDatabase($params);	
				return response::json($response,$authorization);	  
			}
		}		

		if ($request === '/api/sendmail') {

			if($url == "sendmail"){	
				$payload = file_get_contents('php://input'); 				
				$params = json_decode($payload);

				$response = SendMail($params);	
				return response::json($response);	  
			}
		}
		
		if ($request === '/api/recoveruser') {

			if($url == "recoveruser"){
				$mail = $_POST['email'];
				$response = recoverUser($mail);	
				return response::json($response);	  
			}
		}	
		
		if ($request === '/api/writetologfile') {

			if (validateAuthorization($token, $request, "writetotogfile")) {
				$payload = file_get_contents('php://input'); 				
				$params = json_decode($payload);
				$response = writeToLogFileFromDatabase($params);	
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
		$split = (explode("/", $request));	
		$url = $split[2];	

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

		if ($request === '/api/producbystate') {		

			if (validateAuthorization($token, $request, "producbystate")) {	
				$payload = file_get_contents('php://input'); 
				$params = json_decode($payload);				
				$response = updateProducByStateFromDatabase($params);			
				return response::json($response,$authorization);	  
			}
		}

		if ($request === '/api/producbycondition') {		

			if (validateAuthorization($token, $request, "producbycondition")) {					
				$payload = file_get_contents('php://input'); 
				$params = json_decode($payload);				
				$response = updateProducConditionFromDatabase($params);			
				return response::json($response,$authorization);	  
			}
		}		

		if ($request === '/api/productbyqrcode') {		

			if($url == "productbyqrcode"){		
				$payload = file_get_contents('php://input'); 
				$params = json_decode($payload);				
				$response = updateProducByQrCodeFromDatabase($params);			
				return response::json($response);	  
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
