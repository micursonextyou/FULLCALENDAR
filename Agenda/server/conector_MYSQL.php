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






function newInsert($sql2/*$tabla, $campos,$datos*/){

    $sql =$sql2; /*'INSERT INTO '.$tabla.' (';
    $i = 1;
    foreach ($campos as $key => $values) {
      $sql .= $values;
      if ($i<count($campos)) {
        $sql .= ', ';
      }else $sql .= ')';
      $i++;
    }
    $sql .= ' VALUES (';
    $i = 1;
    foreach ($datos as $key => $value) {
      $sql .= $value;
      if ($i<count($datos)) {
        $sql .= ', ';
      }else $sql .= ');';
      $i++;
    }*/

    return $this->ejecutarQuery($sql);

  }

function ActualizarRegistro($tabla/*, $data, $condicion*/){
    $sql = $tabla;/*'UPDATE '.$tabla.' SET ';
    $i=1;
    foreach ($data as $key => $value) {
      $sql .= $key.'='.$value;
      if ($i<sizeof($data)) {
        $sql .= ', ';
      }else $sql .= ' WHERE '.$condicion.';';
      $i++;
    }*/

    return $this->ejecutarQuery($sql);
  }

  function EliminarRegistro($tabla, $condicion){
    $sql = $tabla;
    return $this->ejecutarQuery($sql);
  }


  function consultar($tablas, $campos, $condicion = ""){
    $sql = "SELECT ";
    $ultima_key = end(array_keys($campos));
    foreach ($campos as $key => $value) {
      $sql .= $value;
      if ($key!=$ultima_key) {
        $sql.=", ";
      }else $sql .=" FROM ";
    }

    $ultima_key = end(array_keys($tablas));
    foreach ($tablas as $key => $value) {
      $sql .= $value;
      if ($key!=$ultima_key) {
        $sql.=", ";
      }else $sql .= " ";
    }

    if ($condicion == "") {
      $sql .= ";";
    }else {
      $sql .= $condicion.";";
    }

    return $this->ejecutarQuery($sql);
  }


  function consultaJoin($tablas, $campos, $condicion = ""){
    $sql = "SELECT ";
    $ultima_key = end(array_keys($campos));
    foreach ($campos as $key => $value) {
      $sql .= $value;
      if ($key!=$ultima_key) {
        $sql.=", ";
      }else $sql .=" FROM ";
    }

    $ultima_key = end(array_keys($tablas));
    foreach ($tablas as $key => $value) {
      $sql .= $value;
      if ($key!=$ultima_key) {
        $sql.=" INNER JOIN ";
      }else $sql .= " ";
    }

    if ($condicion == "") {
      $sql .= ";";
    }else {
      $sql .= $condicion.";";
    }
    //print_r($sql);
    return $this->ejecutarQuery($sql);
  }







}


?>
