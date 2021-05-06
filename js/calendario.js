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
    }
    //si existe sessionStorage lo cojo
    if (typeof(Storage) !== "undefined") {
        if (sessionStorage.getItem("fecha")) {
            var fecha = new Date(sessionStorage.getItem("fecha"));
        }else{
            $(location).attr('href', window.location.pathname + parametrosURL[0]);
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
        }
    });
    //añado fecha
    $("#fecha").append(" <span>(" + fecha.getDate() + "/" + fecha.getMonth() + "/" + fecha.getFullYear() + ")</span>");
    //le pongo al select la fecha concatenada con la hora que ya tenia el value por defecto
    if (document.getElementsByTagName("select")) {
        var options = document.getElementsByTagName("option");
        for (let i = 0; i < options.length; i++) {
            if (options[i].getAttribute("value")!="") {
                options[i].setAttribute("value",fecha.getFullYear() + "/" + fecha.getMonth() + "/" + fecha.getDate() + " " + options[i].getAttribute("value"));    
            }
        }
    }
    //click en datepicker
    $("#datepicker").datepicker({
        onSelect: function(dateText, inst) {
            var fecha = $(this).datepicker( 'getDate' ); //coge fecha usando objeto date
            sessionStorage.setItem("fecha",fecha);
            var diasSemana = ["Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado"];
            //quitar ajax, no necesario, solo la redireccion
            $.ajax({
               // aqui va la ubicación de la página PHP
               url: window.location.pathname + parametrosURL[0],
               type: 'POST',
               dataType: 'html',
               //data: diasSemana[fecha.getDay()],
               data: { condicion: "datosDia"},
               success:function(resultado){
                   // imprime "resultado Funcion"
                   //console.log(resultado);
                   $(location).attr('href', window.location.pathname + parametrosURL[0] + '&d=' + diasSemana[fecha.getDay()]);
                }
            })
        }
    });
});