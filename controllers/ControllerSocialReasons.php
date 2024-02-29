<?php

require_once 'db.php';


function getAllSocialReasonsFromDatabase(){
	$db = new ConnectionDatabase();
    $query = "SELECT * FROM razon_social";
    $resultset = $db->runBaseQuery($query);  	   
	$db->close();	

    return $resultset;
}

function getSocialReasonsByIdFromDatabase($param){
	$db = new ConnectionDatabase();
    $query = "SELECT * FROM razon_social WHERE id=?";
    $resultset = $db->runQuery($query,'d',$bindings=[$param]);  
	$db->close();	

    return $resultset;
}

function getSocialReasonsByNameFromDatabase($param){
	$db = new ConnectionDatabase();
    $param = str_replace("%20", " ", $param);
    $param = trim($param);
    $param = stripslashes($param);
    $param = htmlspecialchars($param);    
    $resultset = $db->runBaseQuery("SELECT * FROM razon_social WHERE nombre=". $param);
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
        $color = !empty($razonsocial->color) ? $razonsocial->color : null;

        $query = "INSERT INTO `razon_social`(`id`, `nombre`, `direccion`, `telefono`, `correo`, `fecha_creacion`, `urlimg`, `color`)
                  VALUES (null,?,?,?,?,?,?,?)";

        $bindings = [
            $razonsocial->nombre, $razonsocial->direccion, $razonsocial->telefono,  $razonsocial->correo, $fecha_creacion, $urlimg,$color
        ];

        $db = new ConnectionDatabase();
        $db->getConnection()->autocommit(FALSE);
        try {        
            if ($db->insert($query, 'sssssss', $bindings)) {         
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
                        "color" => $color,
                        "estado" => "200"
                    ];
                    $db->getConnection()->commit();
                }else{
                    $resultset["estado"] = "404";    
                    $resultset["info"] = "Error al intentar insertar un registro en la tabla usuarios_razon_social.";
                }
            } else {
                $resultset["estado"] = "404";
                $resultset["info"] = "Error al intentar insertar un registro en la tabla razon_social.";
            }
        } catch (PDOException $e) {
            echo "Error al crear razon social: " . $e->getMessage();
        }
        $db->close();
    } else {
        $resultset["estado"] = "404";
        $resultset["info"] = "Error al intentar crear una razon social. Existe problemas con los atributos.";
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
        $color = !empty($razonsocial->color) ? $razonsocial->color : null;

		$query = "UPDATE `razon_social` SET `nombre`=?,`direccion`=?,`telefono`=?,`correo`=?,`fecha_creacion`=?,`urlimg`=?,`color`=? WHERE `id` = ?";	

        $bindings = [
            $nombre, $direccion, $telefono, $correo, $fecha_creacion, $urlimg, $color, $id
        ];

		$db = new ConnectionDatabase();
        $db->getConnection()->autocommit(FALSE);
        try {
            if ($db->insert($query, 'sssssssd', $bindings)) {                			
                $resultset = [
                    "id" => $id,
                    "nombre" => $nombre,
                    "direccion" => $direccion,
                    "telefono" => $telefono,
                    "correo" => $correo,
                    "fecha_creacion" => $fecha_creacion,
                    "urlimg" => $urlimg,
                    "color" => $color,
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
