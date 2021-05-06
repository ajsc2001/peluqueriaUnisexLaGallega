<?php
require "class/servicio.php";
require "class/horario.php";
function datosDia($diaSemana){
    $horario = new Horario($_SESSION['tipo']);
    $dia = $horario->obtenerDia($diaSemana);
    return $dia;
}
if (isset($_POST['reservar'])) {
    function validarDatos($datos){
        if (!isset($datos['servicios'])) {
            return "Tiene que seleccionar algún servicio";
        }
        if ($datos['fecha']=="") {
            return "Tiene que seleccionar una fecha";
        }
        return "";
    }
    $msg = validarDatos($_POST);


print_r($_POST);


    if ($msg!="") {
        ?>
        <div class="alert alert-danger centrarAlert" role="alert">
            <?php echo $msg ?>
        </div>
        <?php
    }





    //$fecha = date("Y/m/d H:i:s");//tambien puedo poner o en vez de Y
}






?>
<section>
    <article>
    <article>
        <div id="datepicker"></div>
    </article>
    </article>
    <article id='verde'>
        <h1>Pedir cita</h1>
        <?php
        if (isset($_GET['d'])) {
            $dia = $_GET['d'];
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
        }
        $dia = datosDia($dia);
        if ($dia) {
            echo "<p id='fecha'>".$dia['dia']."</p>";
            if ($dia['cerrado']) {
                echo "<p id='cerrado'>CERRADO</p>";
            }else{
                $servicio = new Servicio($_SESSION['tipo']);
                if (!$servicio->obtenerServicios()) {
                    ?>
                    <div class="alert alert-warning centrarAlert" role="alert">
                        No hay ningún servicio disponible. Pongase en <a href="<?php echo $_SERVER['PHP_SELF'] ?>?p=contacto">contacto</a> con nosotros.
                    </div>
                    <?php
                }else{
                    function llenarHoras($dia){
                        $horas = array();
                        $hora = intval(substr($dia['aperturaMañana'],0,-6));
                        $minutos = intval(substr($dia['aperturaMañana'],3,-3));
                        $cadena = str_pad($hora, 2, "0", STR_PAD_LEFT).":".str_pad($minutos, 2, "0", STR_PAD_LEFT);
                        array_push($horas,$cadena);
                        while ($cadena != substr($dia['cierreMañana'],0,-3)) {
                            $minutos += 15;
                            if ($minutos>=60) {
                                $minutos -= 60;
                                $hora++;
                            }
                            $cadena = str_pad($hora, 2, "0", STR_PAD_LEFT).":".str_pad($minutos, 2, "0", STR_PAD_LEFT);
                            array_push($horas,$cadena);
                        }
                        $hora = intval(substr($dia['aperturaTarde'],0,-6));
                        $minutos = intval(substr($dia['aperturaTarde'],3,-3));
                        $cadena = str_pad($hora, 2, "0", STR_PAD_LEFT).":".str_pad($minutos, 2, "0", STR_PAD_LEFT);
                        array_push($horas,$cadena);
                        while ($cadena != substr($dia['cierreTarde'],0,-3)) {
                            $minutos += 15;
                            if ($minutos>=60) {
                                $minutos -= 60;
                                $hora++;
                            }
                            $cadena = str_pad($hora, 2, "0", STR_PAD_LEFT).":".str_pad($minutos, 2, "0", STR_PAD_LEFT);
                            array_push($horas,$cadena);
                        }
                        return $horas;
                    }
                    $horas = llenarHoras($dia);
                    $servicios = $servicio->obtenerServicios();
                    ?>
                    <h2>Motivo/s:</h2>
                    <form action="<?php echo $_SERVER['PHP_SELF'] ?>?p=citas" method="POST">
                        <div id="motivos">
                            <?php
                            foreach($servicios as $servicio){
                                ?>
                                <label><input type="checkbox" name="servicios[<?php echo $servicio['nombre'] ?>]" value="<?php echo substr($servicio['tiempo'], 0, -3) ?>"><span><?php echo $servicio['nombre'] ?></span></label>
                                <?php
                            }
                            ?>
                        </div>
                        <select name="fecha">
                            <option value=""></option>
                            <?php
                            foreach ($horas as $hora){
                                echo "<option value='$hora'";
                                /*if ($hora==substr($value2, 0, -3)) {
                                    echo "selected='selected'";
                                }*/
                                echo ">$hora</option>";
                            }
                            ?>
                        </select>
                        <input type="submit" name="reservar" value="Reservar">
                    </form>
                    <?php
                }
            }
        }else{
            ?>
            <div class="alert alert-info centrarAlert" role="alert">
                No hay ningún horario para el dia seleccionado. Pongase en <a href="<?php echo $_SERVER['PHP_SELF'] ?>?p=contacto">contacto</a> con nostros para más información
            </div>
            <?php
        }
        ?>
    </article>
</section>