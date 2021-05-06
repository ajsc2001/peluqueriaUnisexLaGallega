$(function() {
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
    $("#modificaciones").slideUp(0).slideDown();
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
            url: window.location.pathname + "?p=administracion",
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
        var container = $("#modificaciones");
        if (!container.is(e.target) && $(e.target).closest(container).length == 0) {
            //si hago click fuera de la caja de modificaciones elimino las sesiones de js y php
            sessionStorage.removeItem("paginaActual");
            $.ajax({
                url: window.location.pathname + "?p=administracion",
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
    $("i.servicio").click(function(){
        var id_servicio = $(this).parent().siblings(":first-child").text();
        var respuesta = confirm("¿Seguro que quiere eliminar el servicio nº" + id_servicio + "?");
        if (respuesta) {
            $.ajax({
                // aqui va la ubicación de la página PHP
                url: window.location.pathname + "?p=administracion",
                type: 'POST',
                dataType: 'html',
                data: {servicio: id_servicio},
                success:function(resultado){
                    alert("El servicio nº" + id_servicio + " ha sido eliminado");
                    //fuerzo recarga de la página y hago click en el mismo boton para actualizar la tabla
                    $(location).attr('href', window.location.pathname + "?p=administracion");
                    $("input[name='servicios']").click();
                }
            })
        }else{
            alert("El servicio nº" + id_servicio + " no ha sido eliminado");
        }  
    });
    $("i.usuario").click(function(){
        var id_usuario = $(this).parent().siblings(":first-child").text();
        var respuesta = confirm("¿Seguro que quiere eliminar el usuario nº" + id_usuario + "?");
        if (respuesta) {
            $.ajax({
                url: window.location.pathname + "?p=administracion",
                type: 'POST',
                dataType: 'html',
                data: {usuario: id_usuario},
                success:function(resultado){
                    alert("El usuario nº" + id_usuario + " ha sido eliminado");
                    //fuerzo recarga de la página y hago click en el mismo boton para actualizar la tabla
                    $(location).attr('href', window.location.pathname + "?p=administracion");
                    $("input[name='usuarios']").click();
                }
            })
        }else{
            alert("El usuario nº" + id_usuario + " no ha sido eliminado");
        }  
    });







    

    $("aperturaMañanaLunes").change(function(){
        alert("aperturaMañanaLunes").val();
    });




    var diasSemana = ["Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado"];
    for (let i = 0; i < diasSemana.length; i++) {
        $("aperturaMañana"+diasSemana[i]).change(function(){
            alert(this).val();
        });
    }














});