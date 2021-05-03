<?php
require "class/horario.php";
function datosDia($diaSemana){
    $horario = new Horario($_SESSION['tipo']);
    $dia = $horario->obtenerDia($diaSemana);
    return $dia;
}
?>
<section>
    <article>
        <div id="datepicker"></div><!--$( ".selector" ).datepicker( "getDate" );      coge fecha-->
    </article>
    <article id='verde'>
        <h1>Horario</h1>
        <div id='horario'>
            <?php
            if(isset($_REQUEST["condicion"])){
                if($_REQUEST["condicion"] == "datosDia" ){
                    echo datosDia($_GET['d']);
                    // salimos de la pagina php y devolvemos la respuesta
                    exit();
                }else{
                    echo "otra funcion o respuesta";
                    // salimos de la pagina php y devolvemos la respuesta
                    exit();
                }
            }
            if (isset($_GET['d'])) {
                $dia = datosDia($_GET['d']);
                print_r($dia);
            }else{
                $dia = date("l");
                switch ($dia) {
                    case "Sunday":
                        $dia = "Domingo";
                        break;
                    case "Monday":
                        $dia = "Lunes";
                        break;
                    case "Tuesday":
                        $dia = "Martes";
                        break;
                    case "Wednesday":
                        $dia = "Miércoles";
                        break;
                    case "Thursday":
                        $dia = "Jueves";
                        break;
                    case "Friday":
                        $dia = "Viernes";
                        break;
                    case "Saturday":
                        $dia = "Sábado";
                        break;
                }
                echo$dia;
                $dia = datosDia($dia);
                echo$dia;
                print_r($dia);
            }
            ?>




            <p>Mañana:</p>
            <p>10:00 - 14:00</p>
            <p>Tarde:</p>
            <p>16:00 - 20:00</p>
        </div>
    </article>
</section>