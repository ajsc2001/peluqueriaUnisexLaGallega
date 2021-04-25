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
    yearSuffix: '',
    showButtonPanel: true
};
$.datepicker.setDefaults($.datepicker.regional['es']);
$(function() {
    $("#datepicker").datepicker({
        onSelect: function(dateText, inst) {
           var fecha = $(this).datepicker( 'getDate' ); //usa objeto date
           var diasSemana = ["Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado"];
           alert(diasSemana[fecha.getDay()]);
           $.ajax({
               // aqui va la ubicación de la página PHP
               url: 'http://localhost/peluqueriaUnisexLaGallega/index.php?p=horario',
               type: 'POST',
               data: diasSemana[fecha.getDay()],
               dataType: 'html',
               data: { condicion: "datosDia"},
               success:function(resultado){
                   // imprime "resultado Funcion"
                   console.log(resultado);
                   $(location).attr('href','http://localhost/peluqueriaUnisexLaGallega/index.php?p=horario&d=' + diasSemana[fecha.getDay()]);
                }
            })
        }
     });
});