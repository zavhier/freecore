<?php

require_once 'db.php';
require_once 'response.php';

function getProducAllFromDatabase(){
	$db = new ConnectionDatabase();
    $query = "SELECT * FROM productos";
    $resultset = $db->runBaseQuery($query);  	   
	$db->close();	

    return $resultset;
}

function getProducByIdFromDatabase($id){
	$db = new ConnectionDatabase();
    $query = "SELECT * FROM productos WHERE id=?";
    $resultset = $db->runBaseQuery($query);  	   
    $resultset = $db->runQuery($query,'d',$bindings=[$id]);  	 
	$db->close();	

    return $resultset;
}

function saveProducFromDatabase($producto) {

    $resultset = [];

    if (
        isset($producto->nombre, $producto->descripcion) &&
        !empty(trim($producto->nombre)) &&
        !empty(trim($producto->descripcion)) &&
        !empty(trim($producto->usuario_id))
    ) {
        $nombre = trim($producto->nombre);
        $descripcion = trim($producto->descripcion);
        $fecha_creacion = date('Y-m-d H:i:s');        
        $codigo_qr = !empty($producto->codigo_qr) ? $producto->codigo_qr : ''; 
        $razon_social_id = !empty($producto->razon_social_id) ? $producto->razon_social_id : null; 
        $usuario_id = trim($producto->usuario_id);

        $query = "INSERT INTO `productos`(`id`, `nombre`, `descripcion`, `fecha_creacion`, `codigo_qr`, `razon_social_id`,`usuario_id`) VALUES (null,?,?,?,?,?,?)";

        $bindings = [$nombre, $descripcion, $fecha_creacion, $codigo_qr,$razon_social_id,$usuario_id];
       
        $db = new ConnectionDatabase();
        $db->getConnection()->autocommit(FALSE);
        try {
            if ($db->insert($query, 'ssssdd', $bindings)) {
                $id = mysqli_insert_id($db->getConnection()); 
                $resultset = [
                    "id" => $id,
                    "nombre" => $nombre,
                    "descripcion" => $descripcion,
                    "fecha_creacion" => $fecha_creacion,
                    "codigo_qr" => $codigo_qr,
                    "razon_social_id" => $razon_social_id,
                    "usuario_id" => $usuario_id,
                    "estado" => "200"
                ];
                
                $db->getConnection()->commit();
            } else {
                $resultset["estado"] = "404";
            }
        } catch (PDOException $e) {
            echo "Error al registrar el producto: " . $e->getMessage();
        }
        $db->close();

    } else {
        $resultset["estado"] = "404";
    }

    return $resultset;
}

function updateProducFromDatabase($producto) {
	
    $resultset = [];

    if (
        isset($producto->id,$producto->nombre, $producto->descripcion,$producto->codigo_qr,$producto->razon_social_id) &&
        !empty(trim($producto->id)) &&
        !empty(trim($producto->nombre)) &&
        !empty(trim($producto->descripcion)) &&
        !empty(trim($producto->codigo_qr)) &&
        !empty(trim($producto->razon_social_id))
    ) {
        $id = trim($producto->id);	
        $nombre = trim($producto->nombre);
        $descripcion = trim($producto->descripcion);
        $fecha_creacion = !empty($producto->fecha_creacion) ? $producto->fecha_creacion : date('Y-m-d H:i:s');      
        $codigo_qr = !empty($producto->codigo_qr) ? $producto->codigo_qr : ''; 
        $razon_social_id = trim($producto->razon_social_id);

        $query = "UPDATE `productos` SET `nombre`=?,`descripcion`=?,`fecha_creacion`=?,`codigo_qr`=?, `razon_social_id`=? WHERE id=?";

        $bindings = [$nombre, $descripcion,$fecha_creacion,$codigo_qr,$razon_social_id,$id];

        $db = new ConnectionDatabase();
        $db->getConnection()->autocommit(FALSE);
        try {
            if ($db->insert($query, 'ssssdd', $bindings)) {                
                $resultset = [
                    "id" => $id,
                    "descripcion" => $descripcion,
                    "fecha_creacion" => $fecha_creacion,
                    "codigo_qr" => $codigo_qr,
                    "estado" => "200"
                ];
                $db->getConnection()->commit();
            } else {
                $resultset["estado"] = "404";
            }
        } catch (PDOException $e) {
            echo "Error al modificar el producto: " . $e->getMessage();
        }
        $db->close();

    } else {
        $resultset["estado"] = "404";
    }

    return $resultset; 
}

function removeProducFromDatabase($id){

    $resultset = ["estado" => "200"]; 

    try {
        $db = new ConnectionDatabase();
	
        $db->initTransaction();
	
        // Eliminar la razón socialun producto
        $query = "DELETE FROM `productos` WHERE id=?";
        $db->delete($query, $id);

        $db->getConnection()->commit();
        $db->close();
    } catch (PDOException $e) {
        if ($db) {
            $db->getConnection()->rollback();
            $db->close();
        }

        $resultset["estado"] = "404";
        $resultset["mensaje"] = "Error al eliminar un producto con referencia $id: " . $e->getMessage();
    }
	
	return $resultset;   
}
