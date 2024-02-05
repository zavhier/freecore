<?php

class template {
	
	// *********************************************************
	
	// Estilos personalizados
	
	// *********************************************************	
	
	public static function myStileTemplate(){
		return  '
				<style>
                        body {
                            font-family: "Arial", sans-serif;
                            background-color: #f4f4f4;
                            margin: 0;
                            padding: 0;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            height: 100vh;
                        }
                
                        .container {
                            background-color: #fff;
                            border-radius: 8px;
                            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                            padding: 20px;
                            max-width: 400px;
                            width: 100%;
                            text-align: center;
                        }
                
                        h1 {
                            color: #333;
                        }
                
                        p {
                            color: #555;
                        }
                
                        .highlight {
                            font-weight: bold;
                            color: #007bff;
                        }
                
                        .footer {
                            margin-top: 20px;
                            color: #777;
                        }
                   </style>		
		';
	}	
	
	
	// *********************************************************
	
	// Template correo electronico para Recuperacion de password
	
	// *********************************************************
	
	public static function emailMenssageRecoverPasswordTemplate($subject,$name,$password){
					
		  $date = date('Y-m-d H:i:s');
		
		  $styleTemplate = self::myStileTemplate();		  

           return '
                <html lang="es">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>'. $subject .'</title>
			   		' . $styleTemplate . ' 
                </head>
                <body>
                    <div class="container">
                        <h1>'. $subject .'</h1>
                        <p>Hola '.$name.',</p>
                        <p>Tu contraseña ha sido cambiada con éxito.</p>
                        <p>Tu nueva contraseña es: <span class="highlight"> '.$password.' </span></p>
                        <p>Si no realizaste este cambio o tienes alguna pregunta, por favor contáctanos.</p>
                        <p><p>Fecha de actualización: '.$date.'</p></p>
                        <p class="footer">¡Gracias!</p>
                    </div>
                </body>
                </html>
                ';
	}	

	// ******************************************************************
	
	// Template correo electronico para envio de mails punto de contacto.
	
	// ******************************************************************
	
	public static function emailPointContactTemplate($subject,$name,$message){
					
		 $date = date('Y-m-d H:i:s');
		
		  $styleTemplate = self::myStileTemplate();

           return '
                <html lang="es">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>'. $subject .'</title>
			   		' . $styleTemplate . ' 
                </head>
                <body>
                    <div class="container">
	                    <h1>'. $subject .'</h1>
                        <p>Hola '.$name.',</p>
                        <p>'. $message .'</p>
                        <p><p>Fecha de actualización: '.$date.'</p></p>
                        <p class="footer">¡Gracias!</p>
                    </div>
                </body>
                </html>
                ';
	}		
	
}

?>