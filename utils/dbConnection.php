<?php

class DbConnection{
  private $server;
  private $user;
  private $password;
  private $dbname;
  private $port;
  private $connection;

  function __construct(){
    $connectionData = $this->loadDbParams();
    foreach($connectionData as $key => $value){
      $this->server = $value['server'];
      $this->user = $value['user'];
      $this->password = $value['password'];
      $this->dbname = $value['dbname'];
      $this->port = $value['port'];
    }
    $this->connection = new mysqli($this->server, $this->user, $this->password, $this->dbname, $this->port);
    if($this->connection->connect_errno){
      echo "connection error";
      die();
    }
    mysqli_set_charset($this->connection, "utf8");
  }
  
  /**
   * loadDbParams
   * carga las credenciales de la db desde el archivo ../utils/dbconfig
   */
  
  private function loadDbParams(){
    $fileDir = $_SERVER['DOCUMENT_ROOT']."/api_v2/utils/dbconfig";
    $jsonData = file_get_contents($fileDir);
    return json_decode($jsonData, true);
  }
  
  
  public function get_connection(){
    return $this->connection;
  }
   
  function __destruct(){}
}
?>
