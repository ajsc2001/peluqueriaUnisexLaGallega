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
        <div id="datepicker"></div>
    </article>
    <article id='verde'>
        <h1>Horario</h1>
        <div id='horario'>
            <?php
            if (isset($_GET['d'])) {
                $dia = $_GET['d'];
            }else{
                $dia = date("l");//cojo el nombre del dia actual
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
            }
            $dia = datosDia($dia);//Cojo los datos del horario para ese
            if ($dia) {
                echo "<p id='fecha'><span>".$dia['dia']."</span></p>";
                if ($dia['cerrado']) {
                    echo "<p id='cerrado'>CERRADO</p>";
                }else{
                    ?>
                    <p>Mañana:</p>
                    <p><span><?php echo substr($dia['aperturaMañana'],0,-3)."</span><span> - </span><span>".substr($dia['cierreMañana'],0,-3) ?></span></p>
                    <p>Tarde:</p>
                    <p><span><?php echo substr($dia['aperturaTarde'],0,-3)."</span><span> - </span><span>".substr($dia['cierreTarde'],0,-3) ?></span></p>
                    <?php 
                }
            }else{
                ?>
                <div class="alert alert-warning centrarAlert" role="alert">
                    No hay ningún horario para el dia seleccionado. Pongase en <a href="<?php echo $_SERVER['PHP_SELF'] ?>?p=contacto">contacto</a> con nostros para más información
                </div>
                <?php
            }
            ?>
        </div>
    </article>
</section>