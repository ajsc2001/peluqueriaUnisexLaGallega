<?php
require "class/horario.php";
function datosDia(){
    print_r($_POST);
    $horario = new Horario($_SESSION['tipo'],"","","","","","","");
    $dia = $horario->obtenerDia($_GET['d']);



    
    print_r($dia);
}
if(isset($_REQUEST["condicion"])){
    // si llega la condicion, y es igual a la condicion que necesitas para entrar ejecuta la función y devuelve el resultado
    if($_REQUEST["condicion"] == "datosDia" ){
       echo datosDia();
       // salimos de la pagina php y devolvemos la respuesta
       exit();
    }else{
       echo "otra funcion o respuesta";
       // salimos de la pagina php y devolvemos la respuesta
       exit();
    }
}
?>
<section>
    <article>
        <div id="datepicker"></div><!--$( ".selector" ).datepicker( "getDate" );      coge fecha-->
    </article>
    <article id='verde'>
        <h1>Horario</h1>
        <div id='horario'>
            <p>Mañana:</p>
            <p>10:00 - 14:00</p>
            <p>Tarde:</p>
            <p>16:00 - 20:00</p>
        </div>
    </article>
</section>