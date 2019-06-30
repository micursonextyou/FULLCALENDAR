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
          //$cons2="SELECT id, titulo, fecha_ini, if(hora_ini<>NULL,hora_ini,""), if(fecha_end<>NULL,fecha_end,""), if(hora_ene<>NULL,hora_ene,""), complet FROM eventos WHERE usuario_id='$id'";
          $cons="SELECT * FROM eventos WHERE usuario_id='$id'";
          $sql=$conexion->consultar($cons);
          if($sql!==false){
            $resp=array();
            while($sql_res=$sql->fetch_array(MYSQLI_ASSOC)){
                //$respuesta[]=$sql_res;
                $evento["id"]=$sql_res['id'];
                $evento["title"]=$sql_res['titulo'];
                if($sql_res['complet']==0){
                    $evento["start"]=$sql_res['fecha_ini']."T".$sql_res['hora_ini'];
                    $evento["end"]=$sql_res['fecha_end']."T".$sql_res['hora_ene'];
                    $evento["allDay"]=false;
                }else{
                  $evento["start"]=$sql_res['fecha_ini'];
                  $evento["allDay"]=true;
                }
                $miselaneos[]=array_filter($evento);

            }
            $respuesta2['miselaneos']=json_encode($miselaneos,JSON_FORCE_OBJECT);
            //$resp=array_filter($respuesta);  //$responce2['eventos']=$sql_respuesta;
            //$JSON=array('error'=>false,'eventos'=>$respuesta2); // $respuesta2['conulta']= json_encode($resp,JSON_FORCE_OBJECT);
           }
           else{
               $respuesta2['ErrorConsulta']=array('error'=>true,'id'=>$id,"sql"=>$sql,"cons"=>$cons);
           }
        }
    }else{
          $respuesta2['Error']="Falla en conectar al servidor";

    }

echo json_encode($respuesta2);
/*                  cerrar conexion                   */
    $conexion->cerrarConexion();
/*----------------------------------------------------*/
?>
