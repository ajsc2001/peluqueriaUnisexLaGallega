//configuración datepicker en castellano
$.datepicker.regional['es'] = {
    closeText: 'Cerrar',
    prevText: '< Ant',
    nextText: 'Sig >',
    currentText: 'Hoy',
    monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
    monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
    dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
    dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
    dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
    weekHeader: 'Sm',
    dateFormat: 'dd/mm/yy',
    firstDay: 1,
    isRTL: false,
    showMonthAfterYear: false,
    yearSuffix: ''
};
$.datepicker.setDefaults($.datepicker.regional['es']);
$(function() {
    //miro si existe el parametro que indica el dia
    var parametrosURL = window.location.search.split("&");
    if (parametrosURL.length<=1) {
        //si no exite cojo la fecha actual y la añado como sesion
        var fecha = new Date();
        sessionStorage.setItem("fecha",fecha);
        var diasSemana = ["Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado"];
        var cadenaFecha = fecha.getFullYear() + "/" + (fecha.getMonth() + 1) + "/" + fecha.getDate();
        $.ajax({
            url: window.location.pathname + parametrosURL[0],
            type: 'POST',
            dataType: 'html',
            data: { condicion: "datosDia", date: cadenaFecha},
            success:function(resultado){
                $(location).attr('href', window.location.pathname + parametrosURL[0] + '&d=' + diasSemana[fecha.getDay()]);
            }
        })
    }
    //si existe sessionStorage lo cojo
    if (typeof(Storage) !== "undefined") {
        if (sessionStorage.getItem("fecha")) {
            var fecha = new Date(sessionStorage.getItem("fecha"));
        }else{
            $(location).attr('href', window.location.pathname + parametrosURL[0]);
        }
        if (sessionStorage.getItem("motivos")) {
            var motivos = sessionStorage.getItem("motivos");
            if ($("input[type=checkbox]")) {
                motivos = motivos.split(", ");
                //si existe alguno en la pagina compruebo los que estaban checked y los pongo checked
                $("input[type=checkbox]").each(function(){
                    for (let i = 0; i < motivos.length; i++) {
                        if ($(this).attr("name") == motivos[i]) {
                            $(this).attr("checked","checked");
                        }
                        
                    }
                });
            }
        }
    }else{
        alert("Es posible que esta página no funcione correctamente en cuanto a aspectos visuales");
    }
    //si hago click fuera de #modificaciones
    $(document).on('touchstart click',function (e){
        var container = $("section");
        if (!container.is(e.target) && $(e.target).closest(container).length == 0) {
            //si hago click fuera del section elimino la sesion de js
            sessionStorage.removeItem("fecha");
            sessionStorage.removeItem("motivos");
            $.ajax({
                url: window.location.pathname + parametrosURL[0],
                type: 'POST',
                dataType: 'html',
                data: {condicion: "borrarSesionesPagina"},
                //no uso el success
                success:function(resultado){
                    //alert("Página eliminada");//poner para que ponga el nick de usuario
                }
            })
        }
    });
    //añado fecha
    $("#fecha").append(" <span>(" + fecha.getDate() + "/" + (fecha.getMonth() + 1) + "/" + fecha.getFullYear() + ")</span>");
    //le pongo al select la fecha concatenada con la hora que ya tenia el value por defecto
    if (document.getElementsByTagName("select")) {
        var options = document.getElementsByTagName("option");
        for (let i = 0; i < options.length; i++) {
            if (options[i].getAttribute("value")!="") {
                options[i].setAttribute("value",fecha.getFullYear() + "/" + (fecha.getMonth() + 1) + "/" + fecha.getDate() + " " + options[i].getAttribute("value"));    
            }
        }
    }
    //click en datepicker
    $("#datepicker").datepicker({
        onSelect: function(dateText, inst) {
            var fecha = $(this).datepicker( 'getDate' ); //coge fecha usando objeto date
            sessionStorage.setItem("fecha",fecha);
            var diasSemana = ["Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado"];
            var cadenaFecha = fecha.getFullYear() + "/" + (fecha.getMonth() + 1) + "/" + fecha.getDate();
            //quitar ajax, no necesario, solo la redireccion
            $.ajax({
                // aqui va la ubicación de la página PHP
               url: window.location.pathname + parametrosURL[0],
               type: 'POST',
               dataType: 'html',
               //data: diasSemana[fecha.getDay()],
               data: { condicion: "datosDia", date: cadenaFecha},
               success:function(resultado){
                   // imprime "resultado Funcion"
                   //console.log(resultado);
                   $(location).attr('href', window.location.pathname + parametrosURL[0] + '&d=' + diasSemana[fecha.getDay()]);
                }
            })
        }
    });
    if ($("input[type=checkbox]")) {
        $("select").attr("disabled","disabled");
        $("input[type='submit']").attr("disabled","disabled");
    }
    if ($("input[type=checkbox]:checked").length>=1) {
        $("select").removeAttr("disabled");
    }
    $("select").change(function(){
        if ($(this).val() != "") {
            $("input[type='submit']").removeAttr("disabled");
        }
    });
    $("input[type=checkbox]").change(function(){
        var motivos = "";
        var tiempo = "";
        var horas = 0;
        var minutos = 0;
        $("input[type=checkbox]:checked").each(function(){
            motivos += $(this).attr("name") + ", ";
            //cada elemento seleccionado
            horas += parseInt($(this).val().substring(0,2));
            minutos += parseInt($(this).val().substring(3));
            if (minutos>=60) {
                minutos -= 60;
                horas++;
            }
        });
        sessionStorage.setItem("motivos",motivos.substring(0, motivos.length - 2))
        //toString necesario para usar la funcion padStart
        //padStart es una funcion que uso para añadir 0 a la izquierda siempre y cuando no tenga ya 2 caracteres númericos
        tiempo = horas.toString().padStart(2,"0") + ":" + minutos.toString().padStart(2,"0");
        $.ajax({
            // aqui va la ubicación de la página PHP
            url: window.location.pathname + parametrosURL[0],
            type: 'POST',
            dataType: 'html',
            //data: diasSemana[fecha.getDay()],
            data: { tiempoNecesario: tiempo},
            success:function(resultado){
                // imprime "resultado Funcion"
                //console.log(resultado);
                $(location).attr('href', window.location.pathname + parametrosURL[0] + "&" + parametrosURL[1]);
             }
         })
    });
    $("input[type='submit']").click(function(){
        alert("Procesando su solicitud de reserva");
    });
});