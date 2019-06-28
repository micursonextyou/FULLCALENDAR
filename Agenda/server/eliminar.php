<?php

require("conector_MYSQL.php");

$conexion=new Conector('localhost','root','mysql');
$responce2['conexion']=$conexion->StarConexion('agenda');

if($responce2['conexion']=="OK"){
      if(isset($_POST['e']) && $_POST['e']){
        session_start();
        if($_SESSION['user_id']){
          $idev=$_POST['e'];
          $f="DELETE FROM eventos WHERE id='$idev'";
          $responce2['consulta']=$f;
          $sql=$conexion->EliminarRegistro($f);
          $responce2['SQL']=$sql;
         }
      }
      else{
        $responce2['SQL']="Datos vacios  ".$_POST['e'];
      }
 }

echo json_encode($responce2);
$conexion->cerrarConexion();


?>
