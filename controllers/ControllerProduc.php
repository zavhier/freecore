<?php

require_once 'db.php';

function getProducAllFromDatabase(){
	$db = new ConnectionDatabase();
    $query = "SELECT * FROM productos";
    try {
        $resultset = $db->runBaseQuery($query);  	   
    } catch (PDOException $e) {
        echo "Error al recuperar todos los productos: " . $e->getMessage();
    }        
	$db->close();	

    return $resultset;
}

function getProducByIdSocialReasonFromDatabase($id){
	$db = new ConnectionDatabase();
    $query = "SELECT * FROM productos WHERE razon_social_id = ? and condicion = 1";
    try {
        $resultset = $db->runQuery($query,'d',$bindings=[$id]);  	 
    } catch (PDOException $e) {
        echo "Error al recuperar los productos por Id de Razon Social: " . $e->getMessage();
    }        
	$db->close();	

    return $resultset;
}

function getProducByQrCodeFromDatabase($code){

    $db = new ConnectionDatabase();
    
    try {

        // Verificar si el codigo Qr existe en la tabla productos.
        $query_check_qr = "SELECT 1 FROM `productos` WHERE codigo_qr=?";
        $qr_exists = $db->runQuery($query_check_qr, 's', $bindings_check_qr = [$code]);
       
        if ($qr_exists){
            // Verificar si el usuario_id es NULL en la tabla productos.
            $query_check_qr = "SELECT 1 FROM `productos` WHERE codigo_qr=? AND usuario_id IS NOT NULL";        
            $user_exists = $db->runQuery($query_check_qr, 's', $bindings_check_qr = [$code]); 

            if ($user_exists) {
                $query = "SELECT 'si' as existe_usuario, 'INFO_PROD' as titulo_1,  p.*, 'INFO_RAZON_SOCIAL' as titulo_2, r.nombre as nombre_rz, r.direccion,r.telefono,r.correo,r.fecha_creacion as fecha_registro, 'INFO_USUARIO' as titulo_3, u.nombre,u.email,u.rol,u.fecha_alta,u.estado,u.genero,u.telcel,u.telref,u.urlimg,u.idempresa FROM productos p LEFT JOIN usuarios u ON p.usuario_id = u.id LEFT JOIN razon_social r ON p.razon_social_id = r.id WHERE p.codigo_qr = ?";
            }else{
                $query = "SELECT 'no' as existe_usuario, 'INFO_PROD' as titulo_1,  p.*, 'INFO_RAZON_SOCIAL' as titulo_2, r.nombre as nombre_rz, r.direccion,r.telefono,r.correo,r.fecha_creacion as fecha_registro, 'INFO_USUARIO' as titulo_3, '' as nombre,'' as email, '' as rol, '' as fecha_alta, '' as estado, '' as genero, '' as telcel, '' as telref, '' as urlimg, '' as idempresa FROM productos p LEFT JOIN usuarios u ON p.usuario_id = u.id LEFT JOIN razon_social r ON p.razon_social_id = r.id WHERE p.codigo_qr = ?";
            }
            $resultset = $db->runQuery($query,'s',$bindings=[$code]);  	 
        }else{
            $resultset["estado"] = "404";
            $resultset["info"] = "El código Qr ".$code." proporcionado no existe en la tabla Productos.";            
        }

    } catch (PDOException $e) {
        echo "Error al modificar el ID de usuario en la tabla de Productos: " . $e->getMessage();
    }

    $db->close();
	
    return $resultset;
}



function getProducByIdFromDatabase($id){
	$db = new ConnectionDatabase();
    $query = "SELECT * FROM productos WHERE id=?";
    try {
        $resultset = $db->runQuery($query,'d',$bindings=[$id]);  	 
    } catch (PDOException $e) {     
        echo "Error al recuperar un producto por ID de producto: " . $e->getMessage();
    }
	$db->close();	

    return $resultset;
}

function getProducByUserFromDatabase($param){

    $resultset = [];

    $db = new ConnectionDatabase();
    if (isset($param) && !empty(trim($param))) {     
        $query = "SELECT * FROM productos WHERE usuario_id=?";
        try {
            $resultset = $db->runQuery($query,'d',$bindings=[$param]); 
        } catch (PDOException $e) {     
            echo "Error al recuperar un producto por ID de usuario: " . $e->getMessage();
        }             
    }
    $db->close();	

    return $resultset;
}

function getProducTypeFromDatabase(){
	$db = new ConnectionDatabase();
    $query = "SELECT * FROM tipo_producto";
    try {
        $resultset = $db->runBaseQuery($query); 	 
    } catch (PDOException $e) {     
        echo "Error al recuperar los tipos de productos: " . $e->getMessage();
    }        
	$db->close();	

    return $resultset;
}

function getProducEstatusFromDatabase(){
	$db = new ConnectionDatabase();
    $query = "SELECT * FROM tipo_estado";
    try {
        $resultset = $db->runBaseQuery($query); 	 
    } catch (PDOException $e) {     
        echo "Error al recuperar los tipo de estados: " . $e->getMessage();
    }        
	$db->close();	

    return $resultset;
}

function getCompanyFromDatabase(){
	$db = new ConnectionDatabase();
    $query = "SELECT * FROM empresas";
    try {
        $resultset = $db->runBaseQuery($query); 	 
    } catch (PDOException $e) {     
        echo "Error al recuperar todas las empresas: " . $e->getMessage();
    }  
	$db->close();	

    return $resultset;
}

function saveProducFromDatabase($producto) {

    $resultset = [];
    // Condicion necesaria para crear un producto es que deba existir
    // el usuario_id en la tabla Usuario y el razon_social_id en la tabla razon_social,
    // de lo contrario retornara 404.
    if (
        isset($producto->nombre, $producto->descripcion) &&
        !empty(trim($producto->nombre)) &&
        !empty(trim($producto->descripcion)) 
    ) {  
        $nombre = trim($producto->nombre);
        $descripcion = trim($producto->descripcion);
        $fecha_creacion = date('Y-m-d H:i:s');        
        $codigo_qr = !empty($producto->codigo_qr) ? $producto->codigo_qr : ''; 

        $url_qr = !empty($producto->url_qr) ? $producto->url_qr : null; 
        $serial = !empty($producto->serial) ? $producto->serial : null; 
        $razon_social_id = !empty($producto->razon_social_id) ? $producto->razon_social_id : null; 
        $usuario_id = trim($producto->usuario_id) ? $producto->usuario_id : null;
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

function saveProducBarcodeQrFromDatabase($productos) {
    $resultset = [];
    $fecha_creacion = date('Y-m-d H:i:s');

    // Separo los datos por coma para obtener cada elemento
    // $productos es una cadena de codigos qr separadas por ,. 
    $codigos = rtrim($productos->datos, ',');
    $codigos = explode(',', $codigos);

    $razon_social_id = $productos->idRazonSocial;
    $url_qr = $productos->url_qr;
    $urlimg = $productos->urlimg;
    
    $db = new ConnectionDatabase();
    $db->getConnection()->autocommit(FALSE);

    // Crear la consulta SQL para la inserción por lote.
    $query = "INSERT INTO `productos`(`id`, `nombre`, `descripcion`, `fecha_creacion`, `codigo_qr`, `url_qr`, `serial`, `razon_social_id`,`usuario_id`,`tipo_estado_id`,`tipo_producto_id`,`fecha_baja`,`urlimg`,`condicion`) VALUES ";
    $values = []; 

    // Bucle para realizar inserciones en lotes donde
    // construyo las cadenas de valores y los bindings que necesito.
    foreach ($codigos as $codigo) {
        $codigo = fillSpace($codigo);
        if ($codigo) {
            $values[] = "(null, 'ProductoQR', 'Carga_App_Externa', '$fecha_creacion', '$codigo', '$url_qr/$codigo', '$codigo', '$razon_social_id', null, 1, 1, null, '$urlimg', 1)";
        }
    }

    // Combino los valores en una sola cadena separada por comas
    $valuesString = implode(", ", $values);

    // Combino la consulta SQL con los valores
    $query .= $valuesString;

    try {
        if ($db->getConnection()->query($query)) {
            $db->getConnection()->commit();
            $resultset["estado"] = "200";
        } else {
            $db->getConnection()->rollback();
            $resultset["estado"] = "404";
        }        
    } catch (PDOException $e) {
        $resultset["info"] = "saveProducBarcodeQrFromDatabase Error: al registrar el producto " . $e->getMessage();
        $resultset["estado"] = "404";        
    }

    $db->close();
    return $resultset;
}

function updateProducConditionFromDatabase($producto) {
	// Condicion necesaria para actualizar que exista el id de usuario en la tabla Usuario.
    $resultset = [];

    if (
        isset($producto->id) &&
        !empty(trim($producto->id)) 
    ) {
        $id = trim($producto->id);	
        $condicion = !empty($producto->condicion) ? $producto->condicion : 0;
        $fecha_baja = date('Y-m-d H:i:s');

        $query = "UPDATE `productos` SET `fecha_baja`=?,`condicion`=? WHERE id=?";       
        $bindings = [$fecha_baja,$condicion, $id];

        $db = new ConnectionDatabase();
        $db->getConnection()->autocommit(FALSE);
        try {
            $affected_rows = $db->update($query, 'sdd', $bindings);
            if ($affected_rows) {             
                $resultset = [
                    "id" => $id,
                    "filas" => $affected_rows,
                    "estado" => "200"
                ];
                $db->getConnection()->commit();
            } else {
                $resultset["estado"] = "404";
            }
        } catch (PDOException $e) {
            echo "Error al modificar condición del producto: " . $e->getMessage();
        }
        $db->close();

    } else {
        $resultset["estado"] = "404";
    }

    return $resultset; 
}

function updateProducByStateFromDatabase($producto) {
	
    $resultset = [];
    
    if (
        isset($producto->id, $producto->tipo_estado_id) &&
        !empty(trim($producto->id)) &&
        !empty(trim($producto->tipo_estado_id)) 
    ) {
        $id = trim($producto->id);	
        $tipo_estado_id = !empty($producto->tipo_estado_id) ? $producto->tipo_estado_id : 1;
        
        $query = "UPDATE `productos` SET `tipo_estado_id`=? WHERE id=?";

        $bindings = [$tipo_estado_id, $id];

        $db = new ConnectionDatabase();
        $db->initTransaction();
        $db->getConnection()->autocommit(FALSE);
        try {
            if ($db->insert($query, 'dd', $bindings)) {                
                $resultset = ["estado" => "200"];
                $db->getConnection()->commit();
            } else {
                $db->getConnection()->rollback();
                $resultset["estado"] = "404";
                $resultset["info"] = "Es posible que el estado que quiere modificar no exista en la tabla tipo_estado.";
            }
        } catch (PDOException $e) {
            echo "Error al modificar el estado del producto: " . $e->getMessage();
        }
        $db->close();

    } else {
        $resultset["estado"] = "404";
    }

    return $resultset; 
}

function updateProducFromDatabase($producto) {
	
    $resultset = [];
    // Condicion necesaria para actualizar que exista el id de usuario en la tabla Usuario.
    if (
        isset($producto->id,$producto->nombre, $producto->descripcion) &&
        !empty(trim($producto->id)) &&
        !empty(trim($producto->nombre)) 
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
        $condicion = !empty($producto->condicion) ? $producto->condicion : 0;
 
        $query = "UPDATE `productos` SET `nombre`=?,`descripcion`=?,`fecha_creacion`=?,`codigo_qr`=?, `url_qr`=?, ".
        "`serial`=?, `razon_social_id`=?, `usuario_id`=?,`tipo_estado_id`=?,`tipo_producto_id`=?,`fecha_baja`=?,`urlimg`=?,`condicion`=? WHERE id=?";

        $bindings = [$nombre, $descripcion, $fecha_creacion, $codigo_qr,$url_qr,$serial,$razon_social_id,$usuario_id,
                    $tipo_estado_id,$tipo_producto_id,$fecha_baja,$urlimg,$condicion, $id
        ];
            
        $db = new ConnectionDatabase();
        $db->getConnection()->autocommit(FALSE);
        try {
            $affected_rows = $db->update($query, 'ssssssddddssdd', $bindings);
            if ($affected_rows) {             
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
                    "estado" => "200",
                    "filas" => $affected_rows,
                ];
                $db->getConnection()->commit();
            } else {
                $resultset["info"] = "No fue posible realizar la solicitud. Revice si existe el Id de usuario en la tabla Usuarios.";
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

function updateProducByQrCodeFromDatabase($producto) {
    $resultset = ["estado" => "404", "info" => "Faltan datos requeridos para completar la solicitud."];
    
    if (isset($producto->codigo_qr, $producto->usuario_id) && 
        !empty(trim($producto->codigo_qr)) && 
        !empty(trim($producto->usuario_id))) {

        $codigo_qr = trim($producto->codigo_qr);
        $usuario_id = trim($producto->usuario_id);

        $db = new ConnectionDatabase();
        $db->initTransaction();
        $db->getConnection()->autocommit(FALSE);

        try {

            // Verificar si el código QR existe en la tabla productos.
            $query_check_qr = "SELECT 1 FROM `productos` WHERE codigo_qr=?";
            $bindings_check_qr = [$codigo_qr];
            $qr_exists = $db->runQuery($query_check_qr, 's', $bindings_check_qr);          

            // Verificar si el usuario_id existe en la tabla usuarios.
            $query_check_user = "SELECT 1 FROM `usuarios` WHERE id=?";
            $bindings_check_user = [$usuario_id];
            $user_exists = $db->runQuery($query_check_user, 's', $bindings_check_user);

            if ($qr_exists) {
                if ($user_exists) {
                    // El código QR y el usuario_id existen, proceder con la actualización.
                    $query_update = "UPDATE `productos` SET `usuario_id`=? , tipo_estado_id = 2 WHERE codigo_qr=?";
                    $bindings_update = [$usuario_id, $codigo_qr];

                    if ($db->insert($query_update, 'ds', $bindings_update)) {
                        $resultset = ["estado" => "200", "info" => "Actualización exitosa."];
                        $db->getConnection()->commit();
                    } else {
                        // Error al actualizar.
                        $db->getConnection()->rollback();
                        $resultset = ["estado" => "404", "info" => "No fue posible asignar un ID de usuario a la tabla productos."];
                    }
                } else {
                    // El usuario_id proporcionado no existe en la tabla Usuarios.
                    $resultset = ["estado" => "404", "info" => "El ID del usuario proporcionado no existe en la tabla Usuarios."];                    
                }
            } else {
                // El código QR proporcionado no existe en la tabla Productos.
                $resultset = ["estado" => "404", "info" => "El código QR proporcionado no existe en la tabla Productos."];
            }
        } catch (PDOException $e) {
            // Manejar errores de la base de datos.
            echo "Error al modificar el ID de usuario en la tabla de Productos: " . $e->getMessage();
        }

        $db->close();
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

// Reemplazar los espacios vacíos con una cadena vacía
function fillSpace($inputString) {    
    $outputString = str_replace(' ', '', $inputString);
    return $outputString;
}
