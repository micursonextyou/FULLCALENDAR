<?php

/*  incluir archivos   */
require("conector_MYSQL.php");
/*-------------------------*/

/*          conectar       */
$responce2['conexion']=$conexion->StarConexion('agenda');
/*-------------------------*/

/*    verificamos conexion       */
if($responce2['conexion']=='OK'){

/*                  verficar session              */
    session_start();
    if(!$_SESSION['user_id']){
      $sql_respuesta['session']= "La sesion a caducado ";
    }else{
/*          realizamos consultas    */
      $id=$_SESSION['user_id'];
/*          comprobamos post   */
      if (isset($_POST['newevent']) && $_POST['newevent'] ) {
        $evento=$_POST['newevent'];

              $sql=$conexion->newInsert(['eventos'],['eventos','usuarios']);
              $sql_respuesta=$sql->fetchall(PDO::FETCH_ASSOC);
              echo Json_encode($sql_respuesta);
      }
  }
}



/*                  cerrar conexion                   */
$conexion->cerrarConexion();
/*----------------------------------------------------*/
?>
