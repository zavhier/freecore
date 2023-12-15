<?php

require_once 'db.php';
require_once 'response.php';

function getUsersAllFromDatabase(){
	$db = new ConnectionDatabase();
    $query = "SELECT id, nombre, email, rol, fecha_alta, estado, genero, telcel, telref, urlimg FROM usuarios";
    $resultset = $db->runBaseQuery($query);  	   
	$db->close();	

    return $resultset;
}

function getUsersByIdFromDatabase($id){
	$db = new ConnectionDatabase();
    $query = "SELECT id, nombre, email, rol, fecha_alta, estado, genero, telcel, telref, urlimg FROM usuarios WHERE id=?";
    $resultset = $db->runBaseQuery($query);  	   
    $resultset = $db->runQuery($query,'d',$bindings=[$id]);  	 
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

        // Utilizo password_hash para almacenar de forma segura las contraseñas
        $opciones = ['cost' => 12];
        $passwordHash = password_hash($password, PASSWORD_BCRYPT, $opciones);        
        
        $query = "INSERT INTO `usuarios`(`id`, `nombre`, `email`, `password`, `rol`, `fecha_alta`, `estado`, `genero`, `telcel`, `telref`, `urlimg`)
                  VALUES (null,?,?,?,?,?,?,?,?,?,?)";

        $bindings = [
            $nombre, $email, $passwordHash, $rol, $fecha_alta, $estado, $genero, $telcel, $telref, $urlimg
        ];
       
        $db = new ConnectionDatabase();
        $db->getConnection()->autocommit(FALSE);
        try {
            if ($db->insert($query, 'sssssdssss', $bindings)) {
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
