<?php

require_once 'db.php';
require_once './config.php';

function SendMail($email){

    $resultset = [];
        
    if (
        isset($email->nombre, $email->correo,$email->tipoenvio,$email->mensaje) &&
        !empty(trim($email->nombre)) &&
        !empty(trim($email->correo)) && 
        !empty(trim($email->tipoenvio)) &&
        !empty(trim($email->mensaje))
    ) { 

        $fecha = date('Y-m-d H:i:s');

        $De      = config::EMAILFROM;
        $Para    = $email->correo; 
        $Cc      = "";

        if($email->tipoenvio == 1){
            $asunto  = $fecha . " - Notificación de objeto encontrado.";
        }else{
            $asunto  = $fecha . " - Notificación de dispositivo encontrado.";
        }
        
        $mensaje = '
        <html>
            <body >
                <h1>'.$asunto.'</h1>    
                <hr>
                <p style="color:#0000FF">Usuario: '.$email->nombre.'</p>
                <p style="color:#0000FF">Nueva notificación desde formulario punto de contacto website.</p>
                <hr>
                <p><b>'.$email->mensaje.'</b></p>
                <hr>
            </body>
        </html>
        ';
        
        $header  = 'From: ' . $De . " \r\n"; 
        $header .= "X-Mailer: PHP/" . phpversion() . " \r\n"; 
        $header .= "Mime-Version: 1.0 \r\n"; 
        $header .= "Content-Type: text/html"; 
        
        mail("$Para, $Cc", $asunto, utf8_decode($mensaje), $header);         
        
    }

    $resultset["mensaje"]='Envio de mail automatico';
    $resultset["estado"]="200";

}

