<?php
/*     incluimos archivos       */
	require("conector_MYSQL.php");
/*--------------------------------------------------------*/
/*     realisamos concexion   */
	$conexion=new Conector('localhost','root','mysql');
	$responce['conexion']=$conexion->StarConexion('agenda');
/*--------------------------------------------------------*/
/*          comprobamos los $_POST                   */
if (isset($_POST['correo']) && $_POST['correo'] && isset($_POST['clave']) && $_POST['clave']) {
	if($responce['conexion']=="OK"){ /*        verificar conexion         */

/*         realisamos la consulta     */
$cc=$_POST['correo'];
$cl=$_POST['clave'];
			$sql=$conexion->consultar("SELECT * FROM usuarios WHERE email='$cc' AND pass='$cl'");

/*        verificar resultados         */
			if($sql->num_rows==1){
				$usuario=$sql->fetch_assoc();

/*             creamos session                   */
				session_start();
				$_SESSION['user_id']=$usuario['id'];
				$_SESSION['user_email']=$usuario['email'];

/*             creamos json                        */
				$json=array('error'=>false,'acceso'=>9,"user"=>$usuario);
				echo json_encode($json);


			}else{
						echo json_encode(array("error"=>true));
			}
			}
}
/*        cerramos         */
$conexion->cerrarConexion();

?>
