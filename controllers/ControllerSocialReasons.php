<?php

require_once 'db.php';
require_once 'response.php';


function getAllSocialReasonsFromDatabase(){
	$db = new ConnectionDatabase();
    $query = "SELECT * FROM razon_social";
    $resultset = $db->runBaseQuery($query);  	   
	$db->close();	

    return $resultset;
}

function saveSocialReasonFromDatabase($razonsocial){
    $resultset = [];

    if (
        isset($razonsocial->nombre, $razonsocial->direccion, $razonsocial->telefono,$razonsocial->correo,$razonsocial->idusuario) &&
        !empty(trim($razonsocial->nombre)) &&
        !empty(trim($razonsocial->direccion)) &&
        !empty(trim($razonsocial->telefono)) &&
        !empty(trim($razonsocial->correo)) &&
        !empty(trim($razonsocial->idusuario))        
    ) {
        $fecha_creacion = date('Y-m-d H:i:s');
        $urlimg = !empty($razonsocial->urlimg) ? $razonsocial->urlimg : null;
        
        $query = "INSERT INTO `razon_social`(`id`, `nombre`, `direccion`, `telefono`, `correo`, `fecha_creacion`, `urlimg`)
                  VALUES (null,?,?,?,?,?,?)";

        $bindings = [
            $razonsocial->nombre, $razonsocial->direccion, $razonsocial->telefono,  $razonsocial->correo, $fecha_creacion, $urlimg
        ];

        $db = new ConnectionDatabase();
        $db->getConnection()->autocommit(FALSE);
        try {        
            if ($db->insert($query, 'ssssss', $bindings)) {         
                // capturo el ultimo id insertado en la entidad razon_social       
                $id = mysqli_insert_id($db->getConnection());

                // agrego una entrada en la relacion usuarios_razon_social
                $query = "INSERT INTO `usuarios_razon_social`(`id`, `usuario_id`, `razon_social_id`) VALUES (null,?,?)";
                if($db->insert($query, 'dd', $bindings = [$razonsocial->idusuario,$id])){
                    $resultset = [
                        "id" => $id,
                        "nombre" => $razonsocial->nombre,
                        "direccion" => $razonsocial->direccion,
                        "telefono" => $razonsocial->telefono,
                        "correo" => $razonsocial->correo,
                        "fecha_creacion" => $fecha_creacion,
                        "urlimg" => $urlimg,
                        "estado" => "200"
                    ];
                    $db->getConnection()->commit();
                }else{
                    $resultset["estado"] = "404";    
                }
            } else {
                $resultset["estado"] = "404";
            }
        } catch (PDOException $e) {
            echo "Error al crear razon social: " . $e->getMessage();
        }
        $db->close();
    } else {
        $resultset["estado"] = "404";
    }

    return $resultset;
}

function updateSocialReasonFromDatabase($razonsocial){
    
	$resultset = [];

    if (
        isset($razonsocial->id, $razonsocial->nombre, $razonsocial->direccion, $razonsocial->correo,$razonsocial->telefono) &&
        !empty(trim($razonsocial->id)) &&
        !empty(trim($razonsocial->nombre)) &&
        !empty(trim($razonsocial->direccion)) &&
		!empty(trim($razonsocial->correo)) &&
        !empty(trim($razonsocial->telefono))
    ) {
        $id = trim($razonsocial->id);
        $nombre = trim($razonsocial->nombre);
		$direccion = trim($razonsocial->direccion);
		$correo = trim($razonsocial->correo);
        $telefono = trim($razonsocial->telefono);
        $fecha_creacion = !empty($razonsocial->fecha_creacion) ? $razonsocial->fecha_creacion : date('Y-m-d H:i:s');
        $urlimg = !empty($razonsocial->urlimg) ? $razonsocial->urlimg : null;

		$query = "UPDATE `razon_social` SET `nombre`=?,`direccion`=?,`telefono`=?,`correo`=?,`fecha_creacion`=?,`urlimg`=? WHERE `id` = ?";	

        $bindings = [
            $nombre, $direccion, $telefono, $correo, $fecha_creacion, $urlimg, $id
        ];

		$db = new ConnectionDatabase();
        $db->getConnection()->autocommit(FALSE);
        try {
            if ($db->insert($query, 'ssssssd', $bindings)) {                			
                $resultset = [
                    "id" => $id,
                    "nombre" => $nombre,
                    "direccion" => $direccion,
                    "telefono" => $telefono,
                    "correo" => $correo,
                    "fecha_creacion" => $fecha_creacion,
                    "urlimg" => $urlimg,
                    "estado" => "200"
                ];
                $db->getConnection()->commit();
            } else {
                $resultset["estado"] = "404";
            }
        } catch (PDOException $e) {
            echo "Error al modificar la razon social: " . $e->getMessage();
        }
        $db->close();

    } else {
        $resultset["estado"] = "404";
    }

    return $resultset; 
}

function removeSocialReasonFromDatabase($id){
	
	$resultset = [];
	
    $db = new ConnectionDatabase();
    $db->getConnection()->autocommit(FALSE);
	$query="DELETE FROM `usuarios_razon_social` WHERE razon_social_id=?";
    try {
        $db->delete($query,$id);
        $db->getConnection()->commit();
    } catch (PDOException $e) {
		$db->getConnection()->rollback();
        echo "Error al eliminar la referencia a usuarios_razon_social ".$id.": " . $e->getMessage();
		$resultset["estado"] = "404";
    }	
	$db->close();

    $db = new ConnectionDatabase();
    $db->getConnection()->autocommit(FALSE);
	$query="DELETE FROM `razon_social` WHERE id=?";
    try {
        $db->delete($query,$id);
        $db->getConnection()->commit();
    } catch (PDOException $e) {
		$db->getConnection()->rollback();
        echo "Error al eliminar la razon_social ".$id.": " . $e->getMessage();
		$resultset["estado"] = "404";
    }	
	$db->close();	
	
	return $resultset; 
}

function removeSocialReasonFromDatabase2($id) {
    $resultset = ["estado" => "200"]; // Estado por defecto (éxito)

    try {
        $db = new ConnectionDatabase();
        $db->initTransaction();

        // Eliminar referencia de usuarios_razon_social
        $query = "DELETE FROM `usuarios_razon_social` WHERE razon_social_id=?";
        $db->delete($query, $id);

        // Eliminar la razón social
        $query = "DELETE FROM `razon_social` WHERE id=?";
        $db->delete($query, $id);

        $db->getConnection()->commit();
        $db->close();
    } catch (PDOException $e) {
        if ($db) {
            $db->getConnection()->rollback();
            $db->close();
        }

        $resultset["estado"] = "404";
        $resultset["mensaje"] = "Error al eliminar la razón social y sus referencias: " . $e->getMessage();
    }

    return $resultset;
}
