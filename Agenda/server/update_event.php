<?php

require("conector_MYSQL.php");
/*          conectar       */
$conexion=new Conector('localhost','root','mysql');
$responce['conexion']=$conexion->StarConexion('agenda');
/*    verificamos conexion       */
if($responce['conexion']=="OK"){
/*                  verficar session              */
if(isset($_POST['id'])&& $_POST['id']){
		session_start();
		if(!$_SESSION['user_id']){
			$responce['session']= "La sesion a caducado ";
		}else{
			$ide=$_SESSION['user_id'];

			$id	= $_POST['id'];
			$fecha_inicio	=$_POST['start_date'];
			$hora_inicio	=$_POST['start_hour'];
			$fecha_fin	=$_POST['end_date'];
			$hora_fin	=$_POST['end_hour'];
			$f="UPDATE eventos SET fecha_ini='$fecha_inicio',hora_ini='$hora_inicio',fecha_end='$fecha_fin',hora_ene='$hora_fin' WHERE id='$id'";
			$responce['pos']=$f;
				$sql=$conexion->ActualizarRegistro($f);
				$responce['SQL']=$sql;

			}
/*          realizamos consultas    */
	}else{
				$responce['Error']="faltan datos en post";
		}
}
echo json_encode($responce);
$conexion->cerrarConexion();

 ?>
