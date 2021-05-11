$(function() {
    $("#eliminarUsuario").click(function(){
        var nick = $("input[name='nick']").val();
        var respuesta = confirm("¿Seguro que quiere eliminar este usuario?");
        if (respuesta) {
            $.ajax({
                url: window.location.pathname + "?p=cuenta",
                type: 'POST',
                dataType: 'html',
                data: { condicion: "eliminarUsuario"},
                success:function(resultado){
                    alert("El usuario " + nick + " ha sido eliminado");
                    $(location).attr('href', window.location.pathname);
                }
            })
        }else{
            alert("El usuario " + nick + " no ha podido ser eliminado");
        }
    });
});