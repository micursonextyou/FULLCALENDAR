

$(function(){

//$("#agregar").click(NuevoEvento);
initForm();
CargarEventos();
$("form").submit(function(event){

  event.preventDefault();
  anadirEvento();
});

});


function limpiar(){
  $("#titulo").val(""),
  $("#start_date").val(""),
  $("#end_date").val("")
  $("#start_hour").val(""),
  $("#end_hour").val("")
}


function initForm(){
  $('#start_date, #titulo, #end_date').val('');
  $('#start_date, #end_date').datepicker({
    dateFormat: "yy-mm-dd"
  });
  $('.timepicker').timepicker({
    timeFormat: 'HH:mm',
    interval: 30,
    minTime: '5',
    maxTime: '21:30',
    defaultTime: '7',
    startTime: '5:00',
    dynamic: false,
    dropdown: true,
    scrollbar: true
  });
  $('#allDay').on('change', function(){
    if (this.checked) {
      $('.timepicker, #end_date').attr("disabled", "disabled")
    }else {
      $('.timepicker, #end_date').removeAttr("disabled")
    }
  })
}





function filtro(cadena){ //fucion para limpiar caracteres raros devueltos por la base de datos

        var exp0=/\\/g;
        var exp1=/[{]["][0-9]["][:]["]/;
        var exp2=/["][,]["][0-9]["][:]["]/g;
        var exp3=/[}]["][}]/;
        var exp4=/[}][}]["][}]/g;
        var exp5=/["][{]["][0-9]["][:]/g;
        var exp6=/["][0-9]["][:]/g;
        var exp7=/[}][}]["]/g;
        var lim0=cadena.replace(exp0,'');
        var lim1=lim0.replace(exp1,"");
        var lim2=lim1.replace(exp2,",\n");
        var lim3=lim2.replace(exp3,"}");
        var lim4=lim3.replace(exp4,"");
        var lim5=lim4.replace(exp5,"");
        var lim6=lim5.replace(exp6,"");
        var lim7=lim6.replace(exp7,"}");
        var cadenaFiltrada="[ "+lim7+"]";
        //console.log(cadenaFiltrada+"   filtrada");
        return cadenaFiltrada;
}

function CargarEventos(){

    $.ajax({
      url: '../server/cargar_eventos.php',
      type: 'GET',
      success:function(respuesta){
        console.log(respuesta+"###########");
        if (respuesta !== null || respuesta !== ''||respuesta!==undefined){
            var ss=JSON.parse(respuesta);
            var myJSON = JSON.stringify(ss.miselaneos);
            var mycadena=filtro(myJSON);
            var evenJson=JSON.parse(mycadena);
            cargar(evenJson);
          }else{
            alert("redireccionando");
            location.href='../client/index.html';
            console.log("ajax null o vacio");
          }
      },
      error: function(resp){
          alert('error de coexion conservidor');
      }

    });
  }
function modificar(event){
  $("#agregar").text("Modificar");
  if($("#agregar").text()=="Modificar"){
    let start = moment(event.start_i).format('YYYY-MM-DD HH:mm:ss');
    start_date = start.substr(0,10);
    start_hour = start.substr(11,8);
    if(event.end!==null){
      end= moment(event.end_i).format('YYYY-MM-DD HH:mm:ss');
      end_date = end.substr(0,10);
      end_hour = end.substr(11,8);
    }else{
      end_date="";
      end_hour="";
    }
    if(event.allDay==false){
    $("#titulo").val(start_date);
    $("#start_date").val(start_date);
    $("#end_date").val(end_date);
    $("#start_hour").val(start_hour);
    $("#end_hour").val(end_hour);
  }else{
    $("#titulo").val(start_date);
    $("#start_date").val(start_date);
    $("#end_date").prop('disabled', false);
    $("#start_hour").prop('disabled', false);
    $("#end_hour").prop('disabled', false);

  }
  }
    return event;

}
function actualizar(event){
        if(event.allDay==false){
        event.title= $("#titulo").val();
        event.start_i= $("#start_date").val()+"T"+$("#start_hour").val() ;
        event.end_i= $("#end_date").val()+"T"+$("#end_hour").val();

      }else{
        event.title= $("#titulo").val();
        event.satart_i= $("#start_date").val();
      }

      $("#end_date").prop('disabled',true );
      $("#start_hour").prop('disabled', true);
      $("#end_hour").prop('disabled', true);
      $("#agregar").text("Añadir");

}

  function cargar(eventos){

      $('#calendario').fullCalendar({
          header: {
          left: 'prev,next today',
          center: 'title',
          right: 'month,agendaWeek,basicDay'
        },

        editable: true,

        droppable: true,
        dragRevertDuration: 0,
        timeFormat: 'H:mm',
        events: eventos,
        eventDrop:function(event){
                actualizarEvento(event);
        },

        eventDragStart: (event,jsEvent) => {
          $('.delete-btn').find('img').attr('src', "img/trash-open.png");
          $('.delete-btn').css('background-color', '#a70f19')

        },
        eventDragStop: (event,jsEvent) =>{

          var trashEl = $('.delete-btn');
          var ofs = trashEl.offset();
          var x1 = ofs.left;
          var x2 = ofs.left + trashEl.outerWidth(true);
          var y1 = ofs.top;
          var y2 = ofs.top + trashEl.outerHeight(true);
          if (jsEvent.pageX >= x1 && jsEvent.pageX<= x2 &&
              jsEvent.pageY >= y1 && jsEvent.pageY <= y2) {
                var event2=event;
                eliminarEvento(event);
                $('#calendario').fullCalendar('removeEvents', event2.id);
          }

        }
      });
  }


function anadirEvento(){
    var end_date;
    var end_hour;
    var start_hour;
    var all,al;
  if (!document.getElementById('allDay').checked) {
    end_date= $('#end_date').val();
    end_hour="T"+ $('#end_hour').val();
    start_hour="T"+ $('#start_hour').val();
    all=false;
    al=0;
  }else {
    end_date= "";
    end_hour= "";
    start_hour= "";
    all=true;
    al=1;
  }

    var ev = {
              title: $('#titulo').val(),
              start:$('#start_date').val()+  start_hour,
              end:end_date+end_hour,
              allDay:all
            };

  var ev_per;
  if (!document.getElementById('allDay').checked) {
     ev_per = {
              titulo: $('#titulo').val(),
              start:$('#start_date').val(),
              horaI:$('#start_hour').val(),
              end: $('#end_date').val(),
              horaE:$('#end_hour').val(),
              allDay:0
            };
    }else{
      ev_per = {
               titulo: $('#titulo').val(),
               start:$('#start_date').val(),
               horaI:null,
               end: null,
               horaE:null,
               allDay:1
             };
    }

console.log(ev_per);
    $.ajax({
      url: '../server/nuevo.php',
      dataType: "json",
      data: ev_per /*$("form").serialize()*/,
      type: 'POST',
      success: function (respuesta){
        console.log(respuesta);
        if (respuesta.conexion=="OK") {
          alert('Se ha añadido el evento exitosamente ');
          $('#calendario').fullCalendar('renderEvent',ev);
        }else {
          alert(respuesta.Error)
        }
      },
      error: function(){
        alert("error en la comunicación con el servidor");
      }
    });
    limpiar();

  }

function  actualizarEvento(evento) {
      let id = evento.id;
      //console.log(id);
      let end, start_date;
      let end_date,start_hour, end_hour;
      let start = moment(evento.start_i).format('YYYY-MM-DD HH:mm:ss');
      start_date = start.substr(0,10);
      start_hour = start.substr(11,8);

      if(evento.end!==null){
        end= moment(evento.end_i).format('YYYY-MM-DD HH:mm:ss');
        end_date = end.substr(0,10);
        end_hour = end.substr(11,8);
      }else{
        end_date="";
        end_hour="";
      }
      //console.log(id+" "+start_date+" "+end_date+" "+start_hour+" "+end_hour);

      $.ajax({
        url: '../server/update_event.php',
        type: 'POST',
        dataType:"json",
        data:  {id:id, start_date:start_date,end_date:end_date,start_hour:start_hour,end_hour:end_hour},
        success:function(respuesta){
          console.log(respuesta);
              if (respuesta.conexion=="OK") {
                  alert("El evento se actaliso correctamente");

              }
        },
        error: function(){
          alert("Error en la comunicación con el servidor");
        }
      })
  }


  function eliminarEvento(event){


      var e={e:event.id};
    $.ajax({
      url: '../server/eliminar.php',
      dataType: "json",
      data: e,
      type: 'POST',
      success: function (respuesta){
        console.log(respuesta);
        if (respuesta.conexion=="OK") {
          alert('Se ha eliminado el evento exitosamente ');
        }else {
          alert("Error ");
        }
      },
      error: function(){
        alert("error en la comunicación con el servidor   \n");
      }
    });
    $('.delete-btn').find('img').attr('src', "img/trash.png");
    $('.delete-btn').css('background-color', '#8B0913')
  }
