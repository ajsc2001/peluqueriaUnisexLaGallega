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
            // aqui va la ubicación de la página PHP
            url: window.location.pathname + "?p=reservas",
            type: 'POST',
            dataType: 'html',
            data: {paginaActual: pagina},
            success:function(resultado){
                //alert("Página actual: " + pagina);//poner para que ponga el nick de usuario
            }
        })
        //redirijo a la misma url para poder ver las cookies
        $(location).attr('href', window.location.href);
        //$(location).attr('href', window.location.href);//a veces con 1 va, otras le hace falta 2
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
                data: {condicion: "eliminarPaginaActual"},
                //no uso el success
                success:function(resultado){
                    //alert("Página eliminada");//poner para que ponga el nick de usuario
                }
            })
        }
      });
});