<?php

    /*  incluir archivos   */
    require("conector_MYSQL.php");
/*          conectar       */
$conexion=new Conector('localhost','root','mysql');
$responce2['conexion']=$conexion->StarConexion('agenda');
/*    verificamos conexion       */
    if($responce2['conexion']=="OK"){
    /*                  verficar session              */
        session_start();
        if(!$_SESSION['user_id']){
          $responce2['session']= "La sesion a caducado ";
        }else{
    /*          realizamos consultas    */
          $id=$_SESSION['user_id'];
          $sql=$conexion->consultaJoin(['eventos','usuarios'],['eventos.id','titulo','fecha_ini','hora_ini','fecha_end','hora_ene','allday'],'ON eventos.usuario_id=usuarios.id WHERE usuarios.id='.$id);
          if($sql!==false){
            $respuesta2=array();
            while($sql_res=$sql->fetch_array(MYSQLI_ASSOC)){
                $respuesta[]=json_encode($sql_res);
            }
            $respuesta2=array_filter($respuesta);
            
                //$responce2['eventos']=$sql_respuesta;
            $JSON=array('error'=>false,'eventos'=>$respuesta2);
             echo json_encode($JSON,JSON_FORCE_OBJECT);
           }
           else{
               echo json_encode(array('error'=>true));
           }
        }
    }else{
          $responce['Error']="Falla en conectar al servidor";

    }


/*                  cerrar conexion                   */
    $conexion->cerrarConexion();
/*----------------------------------------------------*/
?>
