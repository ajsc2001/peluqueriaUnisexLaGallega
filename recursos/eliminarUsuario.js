$(function() {
    $("#eliminarUsuario").click(function(){
        $.ajax({
            // aqui va la ubicación de la página PHP
            url: 'http://localhost/peluqueriaUnisexLaGallega/index.php?p=cuenta',
            type: 'POST',
            dataType: 'html',
            data: { condicion: "eliminarUsuario"},
            success:function(resultado){
                // imprime "resultado Funcion"
                alert("El usuario {nick} a sido eliminado");//poner para que ponga el nick de usuario
                $(location).attr('href','http://localhost/peluqueriaUnisexLaGallega/index.php');
            }
        })
    });
});