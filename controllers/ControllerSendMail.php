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

        $De      = "";
        $Para    = $email->correo; 
        $Cc      = "";
         
        if($email->tipoenvio == 1){
            $De      =  config::getEmailFreeTags();
            $asuntoDefault  = config::getEmailSubjectFreetags();
        }elseif($email->tipoenvio == 2){
            $De      =  config::getEmailSafeBags();
            $asuntoDefault  = config::getEmailSubjectSafebags();
        }
        
        $asunto  = isset($email->asunto) ? trim($email->asunto) : $asuntoDefault;
                		
        if(!empty(trim($email->link))){
            $link = trim($email->link);
        }else{
            $link = '';
        }
        
		$mensaje = template::emailPointContactTemplate($asunto,$email->nombre, $email->mensaje, $link);	
		       
        $header  = 'From: ' . $De . " \r\n"; 
        $header .= "X-Mailer: PHP/" . phpversion() . " \r\n"; 
        $header .= "Mime-Version: 1.0 \r\n"; 
        $header .= "Content-Type: text/html"; 
        
        mail("$Para, $Cc", $asunto, utf8_decode($mensaje), $header);         
        
    }

    $resultset["mensaje"]='Envio de mail automatico';
    $resultset["estado"]="200";

    return $resultset;
    
}

