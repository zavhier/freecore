<?php

require_once 'db.php';

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

function getProducByUserFromDatabase($param){

    $resultset = [];

    $db = new ConnectionDatabase();
    if (isset($param) && !empty(trim($param))) {     
        $query = "SELECT * FROM productos WHERE usuario_id=?";
        $resultset = $db->runQuery($query,'d',$bindings=[$param]);  	 
    }
    $db->close();	

    return $resultset;
}

function getProducTypeFromDatabase(){
	$db = new ConnectionDatabase();
    $query = "SELECT * FROM tipo_producto";
    $resultset = $db->runBaseQuery($query); 	 
	$db->close();	

    return $resultset;
}

function getProducEstatusFromDatabase(){
	$db = new ConnectionDatabase();
    $query = "SELECT * FROM tipo_estado";
    $resultset = $db->runBaseQuery($query); 	 
	$db->close();	

    return $resultset;
}

function getCompanyFromDatabase(){
	$db = new ConnectionDatabase();
    $query = "SELECT * FROM empresas";
    $resultset = $db->runBaseQuery($query); 	 
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

        $url_qr = !empty($producto->url_qr) ? $producto->url_qr : null; 
        $serial = !empty($producto->serial) ? $producto->serial : null; 
        $razon_social_id = !empty($producto->razon_social_id) ? $producto->razon_social_id : null; 
        $usuario_id = trim($producto->usuario_id);
        $tipo_estado_id = !empty($producto->tipo_estado_id) ? $producto->tipo_estado_id : null;
        $tipo_producto_id = !empty($producto->tipo_producto_id) ? $producto->tipo_producto_id : null;
        $fecha_baja = !empty($producto->fecha_baja) ? $producto->fecha_baja : null;
        $urlimg = !empty($producto->urlimg) ? $producto->urlimg : null;
        $condicion = !empty($producto->condicion) ? $producto->condicion : 1;

        $query = "INSERT INTO `productos`(`id`, `nombre`, `descripcion`, `fecha_creacion`, `codigo_qr`, `url_qr`, `serial`, `razon_social_id`,`usuario_id`,`tipo_estado_id`,`tipo_producto_id`,`fecha_baja`,`urlimg`,`condicion`) VALUES (null,?,?,?,?,?,?,?,?,?,?,?,?,?)";

        $bindings = [$nombre, $descripcion, $fecha_creacion, $codigo_qr,$url_qr,$serial,$razon_social_id,$usuario_id,
                    $tipo_estado_id,$tipo_producto_id,$fecha_baja,$urlimg,$condicion
        ];

        $db = new ConnectionDatabase();
        $db->getConnection()->autocommit(FALSE);
        try {
            if ($db->insert($query, 'ssssssddddssd', $bindings)) {
                $id = mysqli_insert_id($db->getConnection()); 
                $resultset = [
                    "id" => $id,
                    "nombre" => $nombre,
                    "descripcion" => $descripcion,
                    "fecha_creacion" => $fecha_creacion,
                    "codigo_qr" => $codigo_qr,
                    "url_qr"=>$url_qr,
                    "serial"=>$serial,
                    "razon_social_id" => $razon_social_id,
                    "usuario_id" => $usuario_id,
                    "tipo_estado_id" => $tipo_estado_id,
                    "tipo_producto_id" => $tipo_producto_id,
                    "fecha_baja" => $fecha_baja,
                    "urlimg" => $urlimg,
                    "condicion" => $condicion,
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
        isset($producto->id,$producto->nombre, $producto->descripcion) &&
        !empty(trim($producto->id)) &&
        !empty(trim($producto->nombre)) &&
        !empty(trim($producto->id))
    ) {
        $id = trim($producto->id);	
        $nombre = trim($producto->nombre);
        $descripcion = trim($producto->descripcion);
        $fecha_creacion = !empty($producto->fecha_creacion) ? $producto->fecha_creacion : date('Y-m-d H:i:s');      
        $codigo_qr = !empty($producto->codigo_qr) ? $producto->codigo_qr : '';         
        $url_qr = !empty($producto->url_qr) ? $producto->url_qr : null; 
        $serial = !empty($producto->serial) ? $producto->serial : null; 
        $razon_social_id = !empty($producto->razon_social_id) ? $producto->razon_social_id : null; 
        $usuario_id = trim($producto->usuario_id);
        $tipo_estado_id = !empty($producto->tipo_estado_id) ? $producto->tipo_estado_id : null;
        $tipo_producto_id = !empty($producto->tipo_producto_id) ? $producto->tipo_producto_id : null;
        $fecha_baja = !empty($producto->fecha_baja) ? $producto->fecha_baja : null; 
        $urlimg = !empty($producto->urlimg) ? $producto->urlimg : null;
        $condicion = !empty($producto->condicion) ? $producto->condicion : 1;
        
        $query = "UPDATE `productos` SET `nombre`=?,`descripcion`=?,`fecha_creacion`=?,`codigo_qr`=?, `url_qr`=?, ".
        "`serial`=?, `razon_social_id`=?, `usuario_id`=?,`tipo_estado_id`=?,`tipo_producto_id`=?,`fecha_baja`=?,`urlimg`=?,`condicion`=? WHERE id=?";

        $bindings = [$nombre, $descripcion, $fecha_creacion, $codigo_qr,$url_qr,$serial,$razon_social_id,$usuario_id,
                    $tipo_estado_id,$tipo_producto_id,$fecha_baja,$urlimg,$condicion, $id
        ];
        $db = new ConnectionDatabase();
        $db->getConnection()->autocommit(FALSE);
        try {
            if ($db->insert($query, 'ssssssddddssdd', $bindings)) {                
                $resultset = [
                    "id" => $id,
                    "nombre" => $nombre,
                    "descripcion" => $descripcion,
                    "fecha_creacion" => $fecha_creacion,
                    "codigo_qr" => $codigo_qr,
                    "url_qr"=>$url_qr,
                    "serial"=>$serial,
                    "razon_social_id" => $razon_social_id,
                    "usuario_id" => $usuario_id,
                    "tipo_estado_id" => $tipo_estado_id,
                    "tipo_producto_id" => $tipo_producto_id,
                    "fecha_baja" => $fecha_baja,
                    "urlimg" => $urlimg,
                    "condicion" => $condicion,
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
