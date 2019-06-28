
 $(function(){
///////////////////////////////////////////////////////////////////
$("form").submit(function(event){
      event.preventDefault();
          var username=$("#user").val();
          var pass=$("#pass").val();
          console.log(username+" "+pass);
          $.ajax({
            url: '../server/check_login.php',
            type: 'POST',
            dataType:"json",
            data:  $("form").serialize(),
            beforeSend:function(){ $("#but").text("Validando....");  },
            success:function(respuesta){
              console.log(respuesta);
                  if (!respuesta.error) {
                        if(respuesta.acceso==9){

                            location.href = '../client/main.html';
                          }else{
                            $("#but").text("Enviar");
                          }
                  }
            },
            error: function(){
              alert("Error en la comunicación con el servidor");
            }
          })
      })
//////////////////////////////////////////////////////////////////////////
})
