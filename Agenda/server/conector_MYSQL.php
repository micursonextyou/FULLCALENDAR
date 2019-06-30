<?php


/* usio un usuario "root" con su pas por defectos "myslq" porque uso el server "ampps" */

class Conector
{
  private $host;
  private $user;
  private $password;
  private $conexion;

  function __construct($host, $user, $password){
    $this->host = $host;
    $this->user = $user;
    $this->password = $password;



  }


  function StarConexion($nombre_db){
    $this->conexion = new mysqli($this->host, $this->user, $this->password, $nombre_db);
    if ($this->conexion->connect_error) {
      return "Error:" . $this->conexion->connect_error;

    }else {
      return "OK";

    }
  }

  function cerrarConexion(){ $this->conexion->close(); }
  function ejecutarQuery($query){

     return $this->conexion->query($query);
  }



function newInsert($sql2){

    $sql =$sql2;
    return $this->ejecutarQuery($sql);

  }

function ActualizarRegistro($tabla){
    $sql = $tabla;

    return $this->ejecutarQuery($sql);
  }

  function EliminarRegistro($tabla, $condicion){
    $sql = $tabla;
    return $this->ejecutarQuery($sql);
  }


function consultar($consulta){
    $sql = $consulta;

    return $this->ejecutarQuery($sql);
  }










}


?>
