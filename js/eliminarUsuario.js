$(function() {
    $("#eliminarUsuario").click(function(){
        var respuesta = confirm("¿Seguro que quiere eliminar este usuario?");
        if (respuesta) {
            $.ajax({
                // aqui va la ubicación de la página PHP
                url: window.location.pathname + "?p=cuenta",
                type: 'POST',
                dataType: 'html',
                data: { condicion: "eliminarUsuario"},
                success:function(resultado){
                    // imprime "resultado Funcion"
                    alert("El usuario {nick} ha sido eliminado");//poner para que ponga el nick de usuario
                    $(location).attr('href', window.location.pathname);
                }
            })
        }else{
            alert("El usuario {nick} no ha podido ser eliminado");
        }
    });
});