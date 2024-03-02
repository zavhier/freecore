<?php

function writeToLogFileFromDatabase($data){

    $resultset["mensaje"]='Se agrego un nueva entrada en el archivo de registros de errores ..ok';
    $resultset["estado"]="200";

    if (
        isset($data->text) &&
        !empty(trim($data->text))
    ) {   
        try {     
            $logFile = 'error_log.txt';
            $fecha = date('Ymd H:i:s');
            $mensaje = $fecha . ': ' . $data->text . PHP_EOL;
            file_put_contents($logFile, $mensaje , FILE_APPEND);
        } catch (Exception $e) {
            echo 'Error al escribir en el archivo de registro de errores: ' . $e->getMessage();
            $resultset["mensaje"]='Error al escribir en el archivo de registro de errores';
            $resultset["estado"]="403";            
        }        
    }

    return $resultset;
    
}

