<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");

// Incluye las rutas y controladores
require 'routes/Routes.php';

// Obtener el token del encabezado
$headers = getallheaders();
$token = isset($headers['Authorization']) ? $headers['Authorization'] : null;

// Manejo de las solicitudes HTTP (GET, POST, PUT, DELETE, etc.)
$method = $_SERVER['REQUEST_METHOD'];
$request = $_SERVER['REQUEST_URI'];
$request = preg_replace('/\/index\.php/m',"", $request);

switch ($method) {

    case 'GET':
        handleGetRequest($request,$token);
        break;
    case 'POST':
        handlePostRequest($request,$token);
        break;
    case 'PUT':
        handlePutRequest($request,$token);
        break;
    case 'DELETE':
        handleDeleteRequest($request,$token);
        break;
    default:
        // Manejar otros métodos según sea necesario
        break;
}
?>