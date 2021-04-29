$(function() {
    $("i.servicio").click(function(){
        var id_servicio = $(this).attr("id");
        var respuesta = confirm("¿Seguro que quiere eliminar este servicio?");
        if (respuesta) {
            $.ajax({
                // aqui va la ubicación de la página PHP
                url: window.location.pathname + "?p=administracion",
                type: 'POST',
                dataType: 'html',
                data: {condicion: "eliminar", id: id_servicio},
                success:function(resultado){
                    // imprime "resultado Funcion"
                    alert("El servicio {nombre} ha sido eliminado");//poner para que ponga el nick de usuario
                    //$(location).attr('href', window.location);
                }
            })
        }else{
            alert("El usuario {nick} no ha podido ser eliminado");
        }  
    });
});