<?php

require_once './db.php';
require_once './config.php';

function getUsersAllFromDatabase(){
	$db = new ConnectionDatabase();
    $query = "SELECT id, nombre, email, rol, fecha_alta, estado, genero, telcel, telref, urlimg FROM usuarios";
    $resultset = $db->runBaseQuery($query);  	   
	$db->close();	

    return $resultset;
}

function getUserByIdFromDatabase($param){
	$db = new ConnectionDatabase();
    $query = "SELECT id, nombre, email, rol, fecha_alta, estado, genero, telcel, telref, urlimg FROM usuarios WHERE id=?";
    $resultset = $db->runQuery($query,'d',$bindings=[$param]);  	 
	$db->close();	

    return $resultset;
}

function getUserByEmailFromDatabase($param){
	$db = new ConnectionDatabase();
    $query = "SELECT id, nombre, email, rol, fecha_alta, estado, genero, telcel, telref, urlimg FROM usuarios WHERE email=?";
    //$param = str_replace("x", "", $param);
    $posicionUltima = strrpos($param, "x");
    if ($posicionUltima !== false) {
        // Reemplazar la última ocurrencia del carácter
        $param = substr_replace($param, "", $posicionUltima, 1);
    }    
    $resultset = $db->runQuery($query,'s',$bindings=[$param]);  	 
	$db->close();	

    return $resultset;
}

function getUserByPhoneFromDatabase($param){
	$db = new ConnectionDatabase();
    $query = "SELECT id, nombre, email, rol, fecha_alta, estado, genero, telcel, telref, urlimg FROM usuarios WHERE telcel=?";
    $resultset = $db->runQuery($query,'s',$bindings=[$param]);  	 
	$db->close();	

    return $resultset;
}

function saveUserFromDatabase($usuario) {
    $resultset = [];

    // Verifico si todas las propiedades necesarias están presentes y no están vacías
    if (
        isset($usuario->nombre, $usuario->password, $usuario->email) &&
        !empty(trim($usuario->nombre)) &&
        !empty(trim($usuario->password)) &&
        !empty(trim($usuario->email))
    ) {
        $nombre = trim($usuario->nombre);
        $email = trim($usuario->email);
        $password = trim($usuario->password);

        // Establezco valores predeterminados o de entrada para las propiedades opcionales
        $fecha_alta = date('Y-m-d H:i:s');
        $estado = 1;
        $rol = isset($usuario->rol) ? trim($usuario->rol) : 'user';
        $genero = isset($usuario->genero) ? trim($usuario->genero) : null;
        $telcel = isset($usuario->telcel) ? trim($usuario->telcel) : null;
        $telref = isset($usuario->telref) ? trim($usuario->telref) : null;
        $urlimg = isset($usuario->urlimg) ? trim($usuario->urlimg) : null;
        $idempresa = isset($usuario->idempresa) ? trim($usuario->idempresa) : 0;

        // Utilizo password_hash para almacenar de forma segura las contraseñas
        $opciones = ['cost' => 12];
        $passwordHash = password_hash($password, PASSWORD_BCRYPT, $opciones);        

        $query = "INSERT INTO `usuarios`(`id`, `nombre`, `email`, `password`, `rol`, `fecha_alta`, `estado`, `genero`, `telcel`, `telref`, `urlimg`, `idempresa`)
                  VALUES (null,?,?,?,?,?,?,?,?,?,?,?)";

        $bindings = [
            $nombre, $email, $passwordHash, $rol, $fecha_alta, $estado, $genero, $telcel, $telref, $urlimg,$idempresa
        ];
       
        $db = new ConnectionDatabase();
        $db->getConnection()->autocommit(FALSE);
        try {
            if ($db->insert($query, 'sssssdssssd', $bindings)) {
                $id = mysqli_insert_id($db->getConnection()); // Obtengo el ID del usuario recién insertado
                $resultset = [
                    "iduser" => $id,
                    "nombre" => $nombre,
                    "email" => $email,
                    "rol" => $rol,
                    "genero" => $genero,
                    "fecha_alta" => $fecha_alta,
                    "telcel" => $telcel,
                    "telref" => $telref,
                    "urlimg" => $urlimg,
                    "idempresa" => $idempresa,
                    "estado" => "200"
                ];
                
                $db->getConnection()->commit();
            } else {
                $resultset["estado"] = "404";
            }
        } catch (PDOException $e) {
            echo "Error al registrar el usuario: " . $e->getMessage();
        }
        $db->close();

    } else {
        $resultset["estado"] = "404";
    }

    return $resultset;
}

function updateUserFromDatabase($usuario) {
	
    $resultset = [];

    if (
        isset($usuario->id, $usuario->nombre, $usuario->password, $usuario->email) &&
        !empty(trim($usuario->id)) &&
        !empty(trim($usuario->nombre)) &&
        !empty(trim($usuario->password)) &&
        !empty(trim($usuario->email))
    ) {
        $id = trim($usuario->id);
        $nombre = trim($usuario->nombre);        
        $password = trim($usuario->password);
        $email = trim($usuario->email);
        $rol = isset($usuario->rol) ? trim($usuario->rol) : 'user';
        $fecha_alta = !empty($usuario->fecha_alta) ? $usuario->fecha_alta : date('Y-m-d H:i:s');
        $estado = isset($usuario->estado) ? trim($usuario->estado) : 1;
        $genero = isset($usuario->genero) ? trim($usuario->genero) : 'N';
        $telcel = isset($usuario->telcel) ? trim($usuario->telcel) : '000-0000';
        $telref = isset($usuario->telref) ? trim($usuario->telref) : '000-0000';
        $urlimg = isset($usuario->urlimg) ? trim($usuario->urlimg) : '';	
		//$empresa = isset($usuario->idempresa) ? trim($usuario->idempresa) : 0;	

        if (!empty($password)) {
            $opciones = ['cost' => 12];
            $password = password_hash($password, PASSWORD_BCRYPT, $opciones);
        }

        $query = "UPDATE `usuarios` SET `nombre`=?, `email`=?, `password`=?, `rol`=?, `fecha_alta`=?, `estado`=?, `genero`=?, `telcel`=?, `telref`=?, `urlimg`=? WHERE `id` = ?";

        $bindings = [
            $nombre, $email, $password, $rol, $fecha_alta, $estado, $genero, $telcel, $telref, $urlimg, $id
        ];

        $db = new ConnectionDatabase();
        $db->getConnection()->autocommit(FALSE);
        try {
            if ($db->insert($query, 'sssssdssssd', $bindings)) {                
                $resultset = [
                    "iduser" => $id,
                    "nombre" => $nombre,
                    "email" => $email,
                    "rol" => $rol,
                    "genero" => $genero,
                    "fecha_alta" => $fecha_alta,
                    "telcel" => $telcel,
                    "telref" => $telref,
                    "urlimg" => $urlimg,
                    "estado" => "200"
                ];
                $db->getConnection()->commit();
            } else {
                $resultset["estado"] = "404";
            }
        } catch (PDOException $e) {
            echo "Error al modificar el usuario: " . $e->getMessage();
        }
        $db->close();

    } else {
        $resultset["estado"] = "404";
    }

    return $resultset; 
}


function removeUserCompletelyFromDatabase($id){
	
    $resultset = ["estado" => "200"]; 

    $db = new ConnectionDatabase();

    try {
        
	    $db->initTransaction();
	
        // Eliminar de la tabla 'productos'
        $query = "DELETE FROM productos WHERE usuario_id IN (SELECT id FROM usuarios WHERE id = ?)";
        $db->delete($query, $id);

        // Eliminar de la tabla 'razon_social'
        $query = "DELETE FROM razon_social WHERE id IN (SELECT razon_social_id FROM usuarios_razon_social WHERE usuario_id = ?)";
        $db->delete($query, $id);

        // Eliminar de la tabla 'usuarios_razon_social'
        $query = "DELETE FROM usuarios_razon_social WHERE usuario_id IN (SELECT id FROM usuarios WHERE id = ?)";
        $db->delete($query, $id);

        // Eliminar de la tabla 'usuarios'
        $query = "DELETE FROM usuarios WHERE id = ?";
        $db->delete($query, $id);

        $db->getConnection()->commit();
        $db->close();
    } catch (PDOException $e) {
        if ($db) {
            $db->getConnection()->rollback();
            $db->close();
        }

        $resultset["estado"] = "404";
        $resultset["mensaje"] = "Error al eliminar usuario definitivamente con Id $id: " . $e->getMessage();
    }
	
	return $resultset; 
}

function recoverUser($email){
        
    // buscar por el input (email) si existe el db. 
    $result = getUserByEmailFromDatabase($email);    
    if(isset($result)){
        $iduser = $result[0]["id"];
        $nombre = $result[0]["nombre"];

        // creo un pass provisorio
        $password = "";
        $length = 5;
        $pattern = "1234567890abcdefghijklmnopqrstuvwxyz";
        $max = strlen($pattern)-1;
        for($i = 0; $i < $length; $i++){
            $password .= substr($pattern, mt_rand(0,$max), 1);
        }        
        //print_r("Debug Pass:" . $password . " ");

        // encripto el pass provisorio para cumplir con las condiciones de seguridad de la db.
        $opciones = ['cost' => 12];
        $passwordHash = password_hash($password, PASSWORD_BCRYPT, $opciones);  
        //print_r(" - Debug Pass Encriptado:" . $passwordHash . " ");

        // actualizar con un pass provisorio la db.
        $query = "UPDATE `usuarios` SET `password`=? WHERE `id` = ?";
        $bindings = [ $passwordHash , $iduser];
        $db = new ConnectionDatabase();
        $db->getConnection()->autocommit(FALSE);
        try {
            if ($db->insert($query, 'sd', $bindings)) {                
                $resultset["estado"] = "200";
                $db->getConnection()->commit();
              
                // enviar un mail con el pass provisorio pidiendo que la cambie.

                $fecha = date('Y-m-d H:i:s');
                $De      =  config::getEmailFrom();
                $Para    = $email; 
                $Cc      = "";
                $asunto  = "Confirmación de Cambio de Contraseña";     
                $mensaje = '
                <html lang="es">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>Confirmación de Cambio de Contraseña</title>
                    <style>
                        body {
                            font-family: "Arial", sans-serif;
                            background-color: #f4f4f4;
                            margin: 0;
                            padding: 0;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            height: 100vh;
                        }
                
                        .container {
                            background-color: #fff;
                            border-radius: 8px;
                            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                            padding: 20px;
                            max-width: 400px;
                            width: 100%;
                            text-align: center;
                        }
                
                        h1 {
                            color: #333;
                        }
                
                        p {
                            color: #555;
                        }
                
                        .highlight {
                            font-weight: bold;
                            color: #007bff;
                        }
                
                        .footer {
                            margin-top: 20px;
                            color: #777;
                        }
                    </style>
                </head>
                <body>
                    <div class="container">
                        <h1>Confirmación de Cambio de Contraseña</h1>
                        <p>Hola '.$nombre.',</p>
                        <p>Tu contraseña ha sido cambiada con éxito.</p>
                        <p>Tu nueva contraseña es: <span class="highlight">['.$password.']</span></p>
                        <p>Si no realizaste este cambio o tienes alguna pregunta, por favor contáctanos.</p>
                        <p><p>Fecha de actualización: '.$fecha.'</p></p>
                        <p class="footer">¡Gracias!</p>
                    </div>
                </body>
                </html>
                ';
                $header  = 'From: ' . $De . " \r\n"; 
                $header .= "X-Mailer: PHP/" . phpversion() . " \r\n"; 
                $header .= "Mime-Version: 1.0 \r\n"; 
                $header .= "Content-Type: text/html"; 
                mail("$Para, $Cc", $asunto, utf8_decode($mensaje), $header);  
                $resultset["estado"] = "200";
            } else {
                $resultset["estado"] = "404";
                $resultset["mensaje"] = "Se produjo un error al intentar cambiar su contraseña.";
            }
        } catch (PDOException $e) {
            echo "Error al modificar el usuario: " . $e->getMessage();
        }
        $db->close();

    }else{
        $resultset["estado"] = "404";
        $resultset["mensaje"] = "El email proporcionado no corresponde a un usuario válido.";
    }
    
    return $resultset; 

}
