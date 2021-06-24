<?php

abstract class Conexion
{
  private $host;
  private $user;
  private $pass;
  private $bdat;
  protected $conn;

  // Al terminar el objeto se cierra la conexión.
  function __destruct()
  {
    $this->conn->close();
  }

  protected function connect()
  {
    $this->getConf();
    
    if($this->host && $this->user && $this->pass && $this->bdat) {

      # Realiza la conexión
      $this->conn = new mysqli($this->host, $this->user, $this->pass, $this->bdat);
      mysqli_set_charset($this->conn, 'utf8'); // Importante poner utf8

      # Maneja posibles errore.
      if ($this->conn->connect_error) die("Connection failed: ". $this->conn->connect_error);

    } else die("Problema con la conexión. Quizá faltan datos en conf.ini.");
  } // connect()

  private function getConf()
  {
    if(file_exists('conf.ini')) {
      $fichero = parse_ini_file('conf.ini');

      $this->host = $fichero["host"];
      $this->user = $fichero["user"];
      $this->pass = $fichero["pass"];
      $this->bdat = $fichero["bdat"];
    }
  }

} // class conexion

?>
