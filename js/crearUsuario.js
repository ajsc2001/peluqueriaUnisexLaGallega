$(function(){
    //funciond e cambio de estilos si error
    function err(campo){
        campo.val("");
        campo.css({"background-color": "tomato"});
    }
    //funciones para cambiar los estilos de los input
	function foco(foco){
		foco.css({"color": "blue", "background-color": "white"});
	}
	function noFoco(foco){
		foco.css({"color": "black"});
	}
    //funciones de validación
    function validarNombreOApellidos(nombreOApellidos){
        var correcto = true;
        var nombresOApellidos = nombreOApellidos.val().split(" ");
        for (var i = 0; i < nombresOApellidos.length; i++) {
            if(!/^[A-Z][a-z]+$/.test(nombresOApellidos[i])){//no admite acentos ni ningun caracter especial
                correcto = false;
            }
        }
        if (!correcto) {
            err(nombreOApellidos);
            alert("Solo la primera letra de cada nombre o apellido en mayúscula\nNo intruduzca acentos ni en el apartado de nombre ni en el de apellidos");
        }
	}
    function validarEdad(edad){
		var correcto = true;
		if(!(edad.val()>=7&&edad.val()<=100)){
			correcto = false;
		}
		if (!correcto) {
            err(edad);
            alert("La edad tiene que estar entre 7 y 100");
		}
	}
    function validarCorreo(correo){
		var correcto = true;
		if(!/^[(a-z0-9\_\-\.)]+@[(a-z0-9\_\-\.)]+\.[(a-z)]{2,15}$/.test(correo.val())){
			correcto = false;
		}
        if (!correcto) {
            err(correo);
            alert("El correo tiene que tener como mínimo este formato: a@aa.aa");
		}
	}
    function validarTelefono(telefono){
		var correcto = true;
		if(telefono.val().length<9){
			correcto = false;
		}
		if (!correcto) {
            err(telefono);
            alert("El numero de telefono tiene que tener 9 numeros como mínimo");
		}
	}
    function validarNick(nick){
        var array = nick.val().split(" ");
        if (nick.val().length<1||array.length>1) {
            err(nick);
            alert("El nombre de usuario no puede contener espacios");
        }
	}
    function validarContraseña(contraseña){
        if (contraseña.val().length<1) {
            err(contraseña);
            alert("No puede dejar la contraseña vacia");
        }
	}
    $("input:not(input[type='submit']").on({
        focus: function(){
            foco($(this));
        },
        blur: function(){
            noFoco($(this));
        },
        change: function(){
            if ($(this).attr("name")=="nombre"||$(this).attr("name")=="apellidos") {
                validarNombreOApellidos($(this));
            }else if ($(this).attr("name")=="edad") {
                validarEdad($(this));
            }else if ($(this).attr("name")=="email") {
                validarCorreo($(this));
            }else if ($(this).attr("name")=="telefono") {
                validarTelefono($(this));
            }else if ($(this).attr("name")=="nick") {
                validarNick($(this));
            }else if ($(this).attr("name")=="contraseña"||$(this).attr("name")=="contraseña2") {
                validarContraseña($(this));
            }
            $("input[type='submit']").attr("disabled","disabled");
            if ($("input[name='nombre']").val().length>=1&&$("input[name='apellidos']").val().length>=1&&$("input[name='edad']").val().length>=1&&$("input[name='email']").val().length>=1&&$("input[name='telefono']").val().length>=1&&$("input[name='nick']").val().length>=1&&$("input[name='contraseña']").val().length>=1&&$("input[name='contraseña2']").val().length>=1) {
                if ($("input[type='submit']").attr("disabled")) {
                    $("input[type='submit']").removeAttr("disabled");
                }
            }
        }
    });
    $("input[type='submit']").attr("disabled","disabled");
});