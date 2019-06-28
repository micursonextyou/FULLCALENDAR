<?php

require("conector_MYSQL.php");

$conexion=new Conector('localhost','root','mysql');
$responce2['conexion']=$conexion->StarConexion('agenda');

if($responce2['conexion']=="OK"){
  if(isset($_POST['titulo'])&& $_POST['titulo']){
     session_start();
     if($_SESSION['user_id']){

       $t=$_POST['titulo'];
       $s=$_POST['start'];
       $hi=$_POST['horaI'];
       $e=$_POST['end'];
       $he=$_POST['horaE'];
       $id=$_SESSION['user_id'];
       $ad=$_POST['allDay'];
       $f="INSERT INTO eventos (titulo, fecha_ini, hora_ini, fecha_end, hora_ene,usuario_id,allday) VALUES ('$t','$s','$hi','$e','$he','$id','$ad')";
       $responce2['pos']=" ".$f;
       $sql=$conexion->newInsert($f);
       $responce2['SQL']=$sql;
     }
  }
}
echo json_encode($responce2);
$conexion->cerrarConexion();


?>
