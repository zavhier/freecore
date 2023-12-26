<?php

class config {

    private static $configLoaded = false;
    private static $config;

    // Método para cargar la configuración desde el archivo

    private static function cargarConfiguracion() {
        if (!self::$configLoaded) {
            self::$config = parse_ini_file(__DIR__ . "/configuracion.ini", false);
            self::$configLoaded = true;
        }        
    }

    // Métodos para configurar la base de datos

    public static function getHost() {
        self::cargarConfiguracion();
        return self::$config["HOST"];
    }

    public static function getUserDB() {
        self::cargarConfiguracion();
        return self::$config["USERDB"];
    }

    public static function getPasswDB() {
        self::cargarConfiguracion();
        return self::$config["PASSWDB"];
    }

    public static function getDatabase() {
        self::cargarConfiguracion();
        return self::$config["DATABASE"];
    }

    // Atributos para configurar el servidor de correo
    public static function getEmailFrom() {
        self::cargarConfiguracion();
        return self::$config["EMAILFROM"];
    }

    public static function getEmailSubjectFreetags() {
        self::cargarConfiguracion();
        return self::$config["SUBJECT_FREETAGS"];
    }    

    public static function getEmailSubjectSafeBags() {
        self::cargarConfiguracion();
        return self::$config["SUBJECT_SAFEBAGS"];
    }    

}

?>