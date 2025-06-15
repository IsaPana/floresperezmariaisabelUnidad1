<?php
class Conexion extends mysqli {
    private $host = 'db5018013046.hosting-data.io';     
    private $user = 'dbu1241124';  
    private $psw = 'HolaMundo7.'; 
    private $database = 'dbs14316354';   
    public function __construct() {
        parent::__construct($this->host, $this->user, $this->psw, $this->database);
        if ($this->connect_error) {
            die("Conexión fallida: " . $this->connect_error);
        }
    }
}
?>
