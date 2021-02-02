<?php

class DbConection{
  private $server;
  private $user;
  private $password;
  private $dbname;
  private $port;

  /**
   * loadDbParams
   * carga las credenciales de la db desde el archivo ../utils/dbconfig
   */
  private function loadDbParams(){
    $fileDir = $_SERVER['DOCUMENT_ROOT']."api_v2/utils/bdconfig";
    $jsonData = file_get_contents($fileDir);

    return json_decode($jsonData, true);
  }
}


$conn = mysqli_connect(
    'localhost',
    'root',
    '',
    'api_tros'
);
if ( !$conn ) {
    die( 'connect error: '.mysqli_connect_error() );
  }

  mysqli_set_charset($conn, "utf8")
?>
