<?php
  
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");
 
date_default_timezone_set("America/Argentina/Buenos_Aires");
		
		
//datos del arhivo
//$nombre_archivo = $_FILES['userfile']['name'];
//$tipo_archivo = $_FILES['userfile']['type'];
//$tamano_archivo = $_FILES['userfile']['size'];		
		
$folderPath = "../assets/upload/";
$resul= array();
$resul["urls"]="";
$urls = "";
$error="";

$file_names = $_FILES["file"]["name"];
for ($i = 0; $i < count($file_names); $i++) {
	$file_name=$file_names[$i];
	
	$tmp = explode(".", $file_name);
	$extension = end($tmp);
	
	$original_file_name = pathinfo($file_name, PATHINFO_FILENAME);
	$file_url = $original_file_name . "-" . date("YmdHis") . "." . $extension;
	$file_url = strtr($file_url, " ", "_");
	
	$resul["urls"].= $file_url;
	
	if(! move_uploaded_file($_FILES["file"]["tmp_name"][$i], $folderPath . $file_url)){
		$error = "error";
	}
}

if( $error == ""){
	$resul["estado"]="ok";
	$resul["mensaje"]="El archivo ha sido cargado correctamente.";		
}else{
	$resul["estado"]="fail";
	$resul["mensaje"]="Ocurrió algún error al subir el fichero. No pudo guardarse.";		
}

print json_encode($resul) . PHP_EOL;
  
?>