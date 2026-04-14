<?php

class Database {
    private $host = "localhost";
    private $db_name = "sistema_asientos";
    private $username = "root";
    private $password = "";

    public function connect(){
        $conn = new mysqli(
            $this->host,
            $this->username,
            $this->password,
            $this->db_name
        );

        if($conn->connect_error){
            die("Connection Error: " . $conn->connect_error);
        }

        return $conn;
    }
}

?>