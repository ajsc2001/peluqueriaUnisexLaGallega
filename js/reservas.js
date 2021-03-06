$(function (){
    var pagina;
    if (typeof(Storage) !== "undefined") {
        if (sessionStorage.getItem("paginaActual")) {
            pagina = parseInt(sessionStorage.getItem("paginaActual"));
        }else{
            pagina = 1;
        }
    } else {
        alert("Es posible que algo de esta página no funcione correctamente por la incompatibilidad con el objeto Storage");
    }
    //actualizo la paginacion
    $(".page-link").click(function(){
        if ($(this).text()=="Anteriores") {
            pagina--;
        } else if ($(this).text()=="Siguientes") {
            pagina++;
        } else {
            pagina = $(this).text();
        }
        sessionStorage.setItem("paginaActual",pagina);
        $.ajax({
            url: window.location.pathname + "?p=reservas",
            type: 'POST',
            dataType: 'html',
            data: {paginaActual: pagina}
        })
        //redirijo a la misma url para poder ver las cookies
        $(location).attr('href', window.location.href);
    });
    //si hago click fuera de #modificaciones
    $(document).on('touchstart click',function (e){
        var container = $("#reservas");
        if (!container.is(e.target) && $(e.target).closest(container).length == 0) {
            //si hago click fuera de la caja de modificaciones elimino las sesiones de js y php
            sessionStorage.removeItem("paginaActual");
            $.ajax({
                url: window.location.pathname + "?p=reservas",
                type: 'POST',
                dataType: 'html',
                data: {condicion: "eliminarPaginaActual"}
            })
        }
      });
      $("i.reserva").click(function(){
        var id_reserva = $(this).parent().siblings(":first-child").text();
        var respuesta = confirm("¿Seguro que quiere eliminar la reserva nº" + id_reserva + "?");
        if (respuesta) {
            $.ajax({
                url: window.location.pathname + "?p=reservas",
                type: 'POST',
                dataType: 'html',
                data: {reserva: id_reserva},
                success:function(resultado){
                    alert("La reserva nº" + id_reserva + " ha sido eliminada");
                    //fuerzo recarga de la página y hago click en el mismo boton para actualizar la tabla
                    $(location).attr('href', window.location.pathname + "?p=reservas");
                }
            })
        }else{
            alert("La reserva nº" + id_reserva + " no ha sido eliminada");
        }  
    });
});