<?php

require_once './db.php';
require_once './config.php';
require_once './templates.php';

function SendMail($email){

    $resultset = [];
        
    if (
        isset($email->nombre, $email->correo,$email->tipoenvio,$email->mensaje) &&
        !empty(trim($email->nombre)) &&
        !empty(trim($email->correo)) && 
        !empty(trim($email->tipoenvio)) &&
        !empty(trim($email->mensaje))
    ) {        
        $De      =  config::getEmailFrom();
        $Para    = $email->correo; 
        $Cc      = "";

        if($email->tipoenvio == 1){
            $asunto  = config::getEmailSubjectFreetags();
        }else{
            $asunto  = config::getEmailSubjectSafeBags();
        }
        		
		$mensaje = template::emailPointContactTemplate($asunto,$email->nombre, $email->mensaje);	
		       
        $header  = 'From: ' . $De . " \r\n"; 
        $header .= "X-Mailer: PHP/" . phpversion() . " \r\n"; 
        $header .= "Mime-Version: 1.0 \r\n"; 
        $header .= "Content-Type: text/html"; 
        
        mail("$Para, $Cc", $asunto, utf8_decode($mensaje), $header);         
        
    }

    $resultset["mensaje"]='Envio de mail automatico';
    $resultset["estado"]="200";

}

