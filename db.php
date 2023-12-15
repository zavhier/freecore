<?php

require_once 'config.php';

class ConnectionDatabase {

	private const host     = config::HOST;
	private const user     = config::USERDB;  
	private const password = config::PASSWDB;     
	private const database = config::DATABASE; 

	private $conn;
	
    function __construct() {
		$this->conn = mysqli_connect(self::host,self::user,self::password,self::database);
        if (!$this->conn) {
            echo "Error: No se pudo conectar a MySQL." . PHP_EOL;
            echo "errno de depuración: " . mysqli_connect_errno() . PHP_EOL;
            echo "error de depuración: " . mysqli_connect_error() . PHP_EOL;
            exit;
        }		
		//mysqli_set_charset( $this->conn, 'utf8_spanish_ci ');
		mysqli_set_charset($this->conn, "utf8");		
        //echo "#Éxito: Se realizó una conexión apropiada a MySQL!";
        //echo "Información del host: " . mysqli_get_host_info($this->conn) . PHP_EOL;
	}	

    function getConnection(){
        return $this->conn;
    }
    
    function initTransaction(){
        return $this->conn->begin_transaction();
    }

    function close(){
        //echo "#Cerrando conexion MySQL!";
        mysqli_close($this->conn);
    }

    function runBaseQuery($query) {
        $result = mysqli_query($this->conn,$query);
        while($row=mysqli_fetch_assoc($result)) {
            $resultset[] = $row;
        }		
        if(!empty($resultset))
        return $resultset;
    }
    
    function runQuery($query, $param_type, $param_value_array) {
        $sql = $this->conn->prepare($query);
        $this->bindQueryParams($sql, $param_type, $param_value_array);
        $sql->execute();
        $result = $sql->get_result();       
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $resultset[] = $row;
                //$resultset = $row;
            }
        }        
        if(!empty($resultset)) {
            return $resultset;
        }
    }
    
    function bindQueryParams($sql, $param_type, $param_value_array) {
        $param_value_reference[] = & $param_type;
        for($i=0; $i<count($param_value_array); $i++) {
            $param_value_reference[] = & $param_value_array[$i];
        }
        call_user_func_array(array(
            $sql,
            'bind_param'
        ), $param_value_reference);
    }

    function insert($query, $param_type, $param_value_array) {
        $sql = $this->conn->prepare($query);
        $this->bindQueryParams($sql, $param_type, $param_value_array);
        if ($sql->execute()) { 
            return 1;
        }else{
            return 0;
        }
    }
    
    function update($query, $param_type, $param_value_array) {
        $sql = $this->conn->prepare($query);
        $this->bindQueryParams($sql, $param_type, $param_value_array);
        $sql->execute();
    }

    function delete($query, $id) {
        $sql = $this->conn->prepare($query);
        $this->bindQueryParams($sql, "i", array($id));
        $sql->execute();
    }    		
	
}

?>