<?php
require "class/servicio.php";
require "class/horario.php";
require "class/cita.php";
function datosDia($diaSemana){
    $horario = new Horario($_SESSION['tipo']);
    $dia = $horario->obtenerDia($diaSemana);
    return $dia;
}
if (isset($_REQUEST['condicion'])&&$_REQUEST['condicion']=="datosDia") {
    echo $_SESSION['fecha'] = $_REQUEST['date'];
    exit();
}
if (isset($_REQUEST['tiempoNecesario'])) {
    echo $_SESSION['tiempoNecesario'] = $_REQUEST['tiempoNecesario'];
    exit();
}
function eliminarSesionesPagina(){
    if (isset($_SESSION['tiempoNecesario'])) {
        unset($_SESSION['tiempoNecesario']);
    }
    if (isset($_SESSION['fecha'])) {
        unset($_SESSION['fecha']);
    }
}
if (isset($_REQUEST['condicion'])&&$_REQUEST['condicion']=="borrarSesionesPagina") {
    echo eliminarSesionesPagina();
}
if (isset($_POST['reservar'])) {
    function validarDatos($datos){
        if (!isset($datos['motivos'])) {
            return "Tiene que seleccionar algún servicio";
        }
        if ($datos['fecha']=="") {
            return "Tiene que seleccionar una fecha";
        }
        return "";
    }
    //falta que si error que se mantengan los datos
    $motivos = array();
    $fecha = "";
    $msg = validarDatos($_POST);
    if ($msg!="") {
        ?>
        <div class="alert alert-danger centrarAlert" role="alert">
            <?php echo $msg ?>
        </div>
        <?php
    }else{
        //si no hay error
        function cadenaMotivos($motivos){
            $cadena = "";
            foreach($motivos as $key => $value){
                //con esta funcion se cual es el último key del array
                if ($key !== array_key_last($motivos)) {
                    $cadena .= "$key, ";
                }else{
                    $cadena .= "$key.";
                }
            }
            return $cadena;
        }
        $motivos = $_POST['motivos'];
        $fecha = $_POST['fecha'];
        //nueva cita
        //no hago implode por que quiero quedarme con las keys del array
        $cita = new Cita($_SESSION['tipo'],"",cadenaMotivos($motivos),$fecha,$_SESSION['tiempoNecesario'],$_SESSION['id']);
        if ($cita->crearCita()) {
            ?>
            <div class="alert alert-success centrarAlert" role="alert">
                La reserva de su cita ha sido exitosa.
            </div>
            <?php
        }else{
            ?>
            <div class="alert alert-danger centrarAlert" role="alert">
                La hora a la que esta intentando reservar su cita esta ocupada.
            </div>
            <?php
        }
    }
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
                    function todasLasHoras($dia){
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
                    function llenarHoras($dia){
                        $horas = array();
                        if (isset($_SESSION['tiempoNecesario'])) {
                            $date = strtotime($_SESSION['fecha']);
                            $date = date("Y-m-d",$date);
                            $cita = new Cita($_SESSION['tipo'],"","",$date);
                            $citas = $cita->obtenerCitasPorFecha();
                            if (count($citas)<1) {
                                $horas = todasLasHoras($dia);
                            }else{
                                $horasCitadasMañana = array();
                                $horasCitadasTarde = array();
                                for ($i=0; $i < count($citas); $i++) { 
                                    foreach($citas[$i] as $key => $value){
                                        //tiempo necesario para la cita
                                        $tiempo = $citas[$i]['tiempo'];
                                        //tiempo de la cita en horas y minutos
                                        $horaTiempo = intval(substr($tiempo,0,2));
                                        $minutosTiempo = intval(substr($tiempo,3, -3));
                                        //añado el tiempo de citas al array de horas citadas correspondiente
                                        if ($key == "fecha") {
                                            //cojo las horas y minutos finales
                                            $hora = intval(substr($value,-8,-3));
                                            $minutos = intval(substr($value,-5,-3));
                                            //cojo las horas y minutos finales
                                            $horaFin = intval(substr($dia['cierreMañana'],0,-6));
                                            $minutosFin = intval(substr($dia['cierreMañana'],3,-3));
                                            if ($hora<$horaFin) {
                                                array_push($horasCitadasMañana,substr($value,-8,-3));
                                                //incremento minutos para cubir el resto de horas de la cita
                                                $minutosTiempo += ($horaTiempo * 60);
                                                $veces = $minutosTiempo / 15;
                                                for ($j=0; $j < $veces; $j++) {
                                                    //incremento de minutos y horas (si procede)
                                                    $minutos += 15;
                                                    if ($minutos>=60) {
                                                        $hora++;
                                                        $minutos -= 60;
                                                    }
                                                    array_push($horasCitadasMañana,str_pad($hora, 2, "0", STR_PAD_LEFT).":".str_pad($minutos, 2, "0", STR_PAD_LEFT));
                                                }
                                            }else if ($hora==$horaFin&&$minutos<=$minutosFin) {
                                                array_push($horasCitadasMañana,substr($value,-8,-3));
                                                //incremento minutos para cubir el resto de horas de la cita
                                                $minutosTiempo += ($horaTiempo * 60);
                                                $veces = $minutosTiempo / 15;
                                                for ($j=0; $j < $veces; $j++) {
                                                    //incremento de minutos y horas (si procede)
                                                    $minutos += 15;
                                                    if ($minutos>=60) {
                                                        $hora++;
                                                        $minutos -= 60;
                                                    }
                                                    array_push($horasCitadasMañana,str_pad($hora, 2, "0", STR_PAD_LEFT).":".str_pad($minutos, 2, "0", STR_PAD_LEFT));
                                                }
                                            }else{
                                                array_push($horasCitadasTarde,substr($value,-8,-3));
                                                //incremento minutos para cubir el resto de horas de la cita
                                                $minutosTiempo += ($horaTiempo * 60);
                                                $veces = $minutosTiempo / 15;
                                                for ($j=0; $j < $veces; $j++) {
                                                    //incremento de minutos y horas (si procede)
                                                    $minutos += 15;
                                                    if ($minutos>=60) {
                                                        $hora++;
                                                        $minutos -= 60;
                                                    }
                                                    array_push($horasCitadasTarde,str_pad($hora, 2, "0", STR_PAD_LEFT).":".str_pad($minutos, 2, "0", STR_PAD_LEFT));
                                                }
                                            }
                                        }
                                    }
                                }
                                //cojo las horas y minutos de la sesion del tiempo que va a tardar
                                $horaSesion = intval(substr($_SESSION['tiempoNecesario'],0,2));
                                $minutosSesion = intval(substr($_SESSION['tiempoNecesario'],3));
                                ///////////////////////////////////////////////////////////////////////////
                                ///////////////////////////////////////////////////////////////////////////
                                ///////////////////////////////MAÑANA//////////////////////////////////////
                                ///////////////////////////////////////////////////////////////////////////
                                ///////////////////////////////////////////////////////////////////////////
                                //cojo las horas y minutos iniciales
                                $hora = intval(substr($dia['aperturaMañana'],0,-6));
                                $minutos = intval(substr($dia['aperturaMañana'],3,-3));
                                //cojo las horas y minutos finales
                                $horaFin = intval(substr($dia['cierreMañana'],0,-6));
                                $minutosFin = intval(substr($dia['cierreMañana'],3,-3));
                                do {
                                    $añadir = false;
                                    //calculo a que hora acabaria la cita que me dispongo a reservar
                                    $horaTotal = $hora + $horaSesion;
                                    $minutosTotal = $minutos + $minutosSesion;
                                    if ($minutosTotal>=60) {
                                        $horaTotal++;
                                        $minutosTotal -= 60;
                                    }
                                    if (count($horasCitadasMañana)>=1) {
                                        //si hay cita, cojo la hora de la primera cita del array
                                        //estas citas estas ordenadas para que salga primero la hora más baja
                                        $horaCita = intval(substr($horasCitadasMañana[0],0,2));
                                        $minutosCita = intval(substr($horasCitadasMañana[0],3));
                                        //hago las comprobaciones a ver si esa cita se podría finalizar antes de la proxima cita
                                        if ($horaTotal<$horaCita) {
                                            $añadir = true;
                                        }else if ($horaTotal==$horaCita) {
                                            if ($minutosTotal<=$minutosCita) {
                                                $añadir = true;
                                            }
                                        }
                                        if ($hora == $horaCita && $minutos == $minutosCita) {
                                            array_shift($horasCitadasMañana);
                                        }
                                    }else{
                                        if ($horaTotal<$horaFin) {
                                            $añadir = true;
                                        }else if ($horaTotal==$horaFin) {
                                            if ($minutosTotal<=$minutosFin) {
                                                $añadir = true;
                                            }
                                        }
                                    }
                                    //añado la hora al array de horas
                                    $cadena = str_pad($hora, 2, "0", STR_PAD_LEFT).":".str_pad($minutos, 2, "0", STR_PAD_LEFT);
                                    if ($añadir) {
                                        array_push($horas,$cadena);
                                    }
                                    //incremento de minutos y horas (si procede)
                                    $minutos += 15;
                                    if ($minutos>=60) {
                                        $hora++;
                                        $minutos -= 60;
                                    }
                                } while ($cadena != substr($dia['cierreMañana'],0,-3));
                                ///////////////////////////////////////////////////////////////////////////
                                ///////////////////////////////////////////////////////////////////////////
                                ////////////////////////////////TARDE//////////////////////////////////////
                                ///////////////////////////////////////////////////////////////////////////
                                ///////////////////////////////////////////////////////////////////////////
                                //cojo las horas y minutos iniciales
                                $hora = intval(substr($dia['aperturaTarde'],0,-6));
                                $minutos = intval(substr($dia['aperturaTarde'],3,-3));
                                //cojo las horas y minutos finales
                                $horaFin = intval(substr($dia['cierreTarde'],0,-6));
                                $minutosFin = intval(substr($dia['cierreTarde'],3,-3));
                                do {
                                    $añadir = false;
                                    //calculo a que hora acabaria la cita que me dispongo a reservar
                                    $horaTotal = $hora + $horaSesion;
                                    $minutosTotal = $minutos + $minutosSesion;
                                    if ($minutosTotal>=60) {
                                        $horaTotal++;
                                        $minutosTotal -= 60;
                                    }
                                    if (count($horasCitadasTarde)>=1) {
                                        //si hay cita, cojo la hora de la primera cita del array
                                        //estas citas estas ordenadas para que salga primero la hora más baja
                                        $horaCita = intval(substr($horasCitadasTarde[0],0,2));
                                        $minutosCita = intval(substr($horasCitadasTarde[0],3));
                                        //hago las comprobaciones a ver si esa cita se podría finalizar antes de la proxima cita
                                        if ($horaTotal<$horaCita) {
                                            $añadir = true;
                                        }else if ($horaTotal==$horaCita) {
                                            if ($minutosTotal<=$minutosCita) {
                                                $añadir = true;
                                            }
                                        }
                                        if ($hora == $horaCita && $minutos == $minutosCita) {
                                            array_shift($horasCitadasTarde);
                                        }
                                    }else{
                                        if ($horaTotal<$horaFin) {
                                            $añadir = true;
                                        }else if ($horaTotal==$horaFin) {
                                            if ($minutosTotal<=$minutosFin) {
                                                $añadir = true;
                                            }
                                        }
                                    }
                                    //añado la hora al array de horas
                                    $cadena = str_pad($hora, 2, "0", STR_PAD_LEFT).":".str_pad($minutos, 2, "0", STR_PAD_LEFT);
                                    if ($añadir) {
                                        array_push($horas,$cadena);
                                    }
                                    //incremento de minutos y horas (si procede)
                                    $minutos += 15;
                                    if ($minutos>=60) {
                                        $hora++;
                                        $minutos -= 60;
                                    }
                                } while ($cadena != substr($dia['cierreTarde'],0,-3));


                                



















                            }
                        }else{
                            $horas = todasLasHoras($dia);
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
                                <label><input type="checkbox" name="motivos[<?php echo $servicio['nombre'] ?>]" value="<?php echo substr($servicio['tiempo'], 0, -3) ?>"><span><?php echo $servicio['nombre'] ?></span></label>
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