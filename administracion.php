<?php
if (isset($_POST['horarios'])||isset($_POST['modificarHorario'])) {
    require "class/horario.php";
}
if (isset($_POST['servicios'])||isset($_POST['añadirYModificarServicios'])) {
    require "class/servicio.php";
}
?>
<section id='admin'>
    <h1>Administración:</h1>
    <article id="administracion">
        <form action="<?php echo $_SERVER['PHP_SELF'] ?>?p=administracion" method="POST">
            <input type="submit" name='usuarios' value="Usuarios">
            <input type="submit" name='servicios' value="Servicios">
            <input type="submit" name='horarios' value="Horarios">
        </form>
    </article>
</section>
<section id="modificaciones">
<?php
if (isset($_POST['modificarHorario'])) {
    $semana = array(
        "Lunes" => array(
            "dia" => "Lunes",
            "aperturaMañana" => $_POST['aperturaMañanaLunes'],
            "cierreMañana" => $_POST['cierreMañanaLunes'],
            "aperturaTarde" => $_POST['aperturaTardeLunes'],
            "cierreTarde" => $_POST['cierreTardeLunes'],
            "cerrado" => isset($_POST['cerradoLunes'])
        ),
        "Martes" => array(
            "dia" => "Martes",
            "aperturaMañana" => $_POST['aperturaMañanaMartes'],
            "cierreMañana" => $_POST['cierreMañanaMartes'],
            "aperturaTarde" => $_POST['aperturaTardeMartes'],
            "cierreTarde" => $_POST['cierreTardeMartes'],
            "cerrado" => isset($_POST['cerradoMartes'])
        ),
        "Miércoles" => array(
            "dia" => "Miércoles",
            "aperturaMañana" => $_POST['aperturaMañanaMiércoles'],
            "cierreMañana" => $_POST['cierreMañanaMiércoles'],
            "aperturaTarde" => $_POST['aperturaTardeMiércoles'],
            "cierreTarde" => $_POST['cierreTardeMiércoles'],
            "cerrado" => isset($_POST['cerradoMiércoles'])
        ),
        "Jueves" => array(
            "dia" => "Jueves",
            "aperturaMañana" => $_POST['aperturaMañanaJueves'],
            "cierreMañana" => $_POST['cierreMañanaJueves'],
            "aperturaTarde" => $_POST['aperturaTardeJueves'],
            "cierreTarde" => $_POST['cierreTardeJueves'],
            "cerrado" => isset($_POST['cerradoJueves'])
        ),
        "Viernes" => array(
            "dia" => "Viernes",
            "aperturaMañana" => $_POST['aperturaMañanaViernes'],
            "cierreMañana" => $_POST['cierreMañanaViernes'],
            "aperturaTarde" => $_POST['aperturaTardeViernes'],
            "cierreTarde" => $_POST['cierreTardeViernes'],
            "cerrado" => isset($_POST['cerradoViernes'])
        ),
        "Sábado" => array(
            "dia" => "Sábado",
            "aperturaMañana" => $_POST['aperturaMañanaSábado'],
            "cierreMañana" => $_POST['cierreMañanaSábado'],
            "aperturaTarde" => $_POST['aperturaTardeSábado'],
            "cierreTarde" => $_POST['cierreTardeSábado'],
            "cerrado" => isset($_POST['cerradoSábado'])
        ),
        "Domingo" => array(
            "dia" => "Domingo",
            "aperturaMañana" => $_POST['aperturaMañanaDomingo'],
            "cierreMañana" => $_POST['cierreMañanaDomingo'],
            "aperturaTarde" => $_POST['aperturaTardeDomingo'],
            "cierreTarde" => $_POST['cierreTardeDomingo'],
            "cerrado" => isset($_POST['cerradoDomingo'])
        )
    );
    $horario = new Horario($_SESSION['tipo'],$semana['Lunes'],$semana['Martes'],$semana['Miércoles'],$semana['Jueves'],$semana['Viernes'],$semana['Sábado'],$semana['Domingo'],);
    $horario->modificarDias();
?>
<div class="alert alert-success centrarAlert" role="alert">
        El horario ha sido modificado.
</div>
<?php
}
if (isset($_POST['horarios'])||isset($_POST['modificarHorario'])) {
    //iniciar objeto horario
    //if (isset($_POST['tipo'])) {
        $horario = new Horario($_SESSION['tipo']);
    //}else{
        //$horario = new Horario();//vacio
    //}
    if ($horario->obtenerDias()) {
        ?>
        <div class="alert alert-warning centrarAlert" role="alert">
            No habia ningún horario disponible. El horario ha sido creado.
        </div>
        <?php
    }//tabla estaba fuera del else, no habia else
//$horario->obtenerDias();
    //añadir arrays asociativos de todos los dias con los datos de la bd
    $semana = array(
        "Lunes" => $horario->get_lunes(),
        "Martes" => $horario->get_martes(),
        "Miercoles" => $horario->get_miercoles(),
        "Jueves" => $horario->get_jueves(),
        "Viernes" => $horario->get_viernes(),
        "Sabado" => $horario->get_sabado(),
        "Domingo" => $horario->get_domingo()
    );
    $horas = array(
        "00:00",
        "00:15",
        "00:30",
        "00:45",
        "01:00",
        "01:15",
        "01:30",
        "01:45",
        "02:00",
        "02:15",
        "02:30",
        "02:45",
        "03:00",
        "03:15",
        "03:30",
        "03:45",
        "04:00",
        "04:15",
        "04:30",
        "04:45",
        "05:00",
        "05:15",
        "05:30",
        "05:45",
        "06:00",
        "06:15",
        "06:30",
        "06:45",
        "07:00",
        "07:15",
        "07:30",
        "07:45",
        "08:00",
        "08:15",
        "08:30",
        "08:45",
        "09:00",
        "09:15",
        "09:30",
        "09:45",
        "10:00",
        "10:15",
        "10:30",
        "10:45",
        "11:00",
        "11:15",
        "11:30",
        "11:45",
        "12:00",
        "12:15",
        "12:30",
        "12:45",
        "13:00",
        "13:15",
        "13:30",
        "13:45",
        "14:00",
        "14:15",
        "14:30",
        "14:45",
        "15:00",
        "15:15",
        "15:30",
        "15:45",
        "16:00",
        "16:15",
        "16:30",
        "16:45",
        "17:00",
        "17:15",
        "17:30",
        "17:45",
        "18:00",
        "18:15",
        "18:30",
        "18:45",
        "19:00",
        "19:15",
        "19:30",
        "19:45",
        "20:00",
        "21:15",
        "21:30",
        "21:45",
        "22:00",
        "22:15",
        "22:30",
        "22:45",
        "23:00",
        "23:15",
        "23:30",
        "23:45"
    );
    $horario->obtenerDias();
    $semana = array(
        "Lunes" => $horario->get_lunes(),
        "Martes" => $horario->get_martes(),
        "Miercoles" => $horario->get_miercoles(),
        "Jueves" => $horario->get_jueves(),
        "Viernes" => $horario->get_viernes(),
        "Sabado" => $horario->get_sabado(),
        "Domingo" => $horario->get_domingo()
    );
    ?>
    <form action="<?php echo $_SERVER['PHP_SELF'] ?>?p=administracion" method="POST">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th class="text-danger" scope="col">HORARIO</th>
                    <th scope="col" colspan="2">Mañana</th>
                    <th scope="col" colspan="2">Tarde</th>
                    <th scope="col">Cerrado</th>
                </tr>
            </thead>
            <tbody>
            <?php
            foreach ($semana as $key => $value) {
                ?>
                <tr>
                    <th scope="row"><?php echo $key ?></th>
                <?php
                foreach ($value as $key2 => $value2){
                    if ($key2!="dia"&&$key2!="cerrado") {
                    ?>
                    <td>
                        <select name="<?php echo $key2.$value['dia'] ?>">
                        <?php
                        foreach ($horas as $hora){
                            echo "<option value='$hora'";
                            if ($hora==substr($value2, 0, -3)) {
                                echo "selected='selected'";
                            }
                            echo ">$hora</option>";
                        }
                        ?>
                        </select>
                    </td>
                    <?php
                    }
                    if ($key2=="cerrado") {
                        ?>
                        <td><input type="checkbox" name="<?php echo $key2.$value['dia'] ?>" <?php if($value2){echo "checked='checked'";} ?>></td>
                        <?php
                    }
                }
                ?>
                </tr>
                <?php
            }
            ?>
            </tbody>
        </table>
        <input type="submit" name="modificarHorario" value="Modificar horario">
    </form>
    <?php
}




















if (isset($_POST['servicios'])||isset($_POST['añadirYModificarServicios'])) {
    $servicio = new Servicio($_SESSION['tipo']);
    if (!$servicio->obtenerServicios()) {
        if (isset($_POST['servicios'])) {
            ?>
            <div class="alert alert-warning centrarAlert" role="alert">
                No hay ningún servicio disponible. Creelo.
            </div>
            <?php
        }
    }else{
        $servicios = $servicio->obtenerServicios();
    }
    if (isset($_POST['añadirYModificarServicios'])) {
        function validarServiciosExistentes($datos){
            foreach($datos as $dato){
                if (empty($dato)) {
                    return false;
                }

            }
            return true;
        }
        function validarServiciosNuevos($datos){
            $cont = 0;
            foreach($datos as $key => $value){
                if (empty($value)) {
                    $cont++;
                }
            }
            if ($cont!=0) {
                return false;
            }
            return true;
        }
        $serviciosExistentes = array_slice($_POST, 0, -3);
        $serviciosNuevos = array_slice($_POST, -3, -1);
        if (!validarServiciosExistentes($serviciosExistentes)) {
            ?>
            <div class="alert alert-danger centrarAlert" role="alert">
                Los campos que tengan a su izquierda un número asignado no pueden estar vacios. Revise todos los campos que haya modificado.
            </div>
            <?php
        }else{
            $nuevos = validarServiciosNuevos($serviciosNuevos);
            if (!$nuevos) {
                ?>
                <div class="alert alert-danger centrarAlert" role="alert">
                    Si rellena un campo de la última fila tiene que rellenar el resto de campos. Revise todos los campos que haya modificado.
                </div>
                <?php
            }else{
                $msg = "";
                if ($servicio->obtenerServicios()) {
                    //modifico los ya existentes
                    for ($i=0; $i < count($servicios); $i++) { 
                        $servicio = new Servicio($_SESSION['tipo'],$servicios[$i]['id'],array_shift($serviciosExistentes),array_shift($serviciosExistentes));
                        $servicio->modificarServicio();
                    }
                    $msg .= "Los datos de servicios anteriores han sido actualizados";
                }
                if ($nuevos) {
                    //creo el nuevo servicio
                    $servicio = new Servicio($_SESSION['tipo'],"",array_shift($serviciosNuevos),array_shift($serviciosNuevos));
                    if ($servicio->nuevoServicio()) {
                        if (strlen($msg)) {
                            $msg .= " y se ha añadido un nuevo servicio.";
                        }else{
                            $msg .= "Se ha añadido un nuevo servicio.";
                        }
				        ?>
			            <div class="alert alert-success centrarAlert" role="alert">
				            <?php
                            echo $msg;
                            ?>
                        </div>
                        <?php
                    }else{
                        if (strlen($msg)) {
                            $msg .= " pero el nuevo servicio no se ha añadido porque ya que existia.";
                        }else{
                            $msg .= "No se ha añadido el nuevo servicio porque ya que existia.";
                        }
                        ?>
			            <div class="alert alert-warning centrarAlert" role="alert">
				            <?php
                            echo $msg;
                            ?>
                        </div>
                        <?php
                    }  
                }
            }
        }
    }
    $horas = array(
        "00:15",
        "00:30",
        "00:45",
        "01:00",
        "01:15",
        "01:30",
        "01:45",
        "02:00",
        "02:15",
        "02:30",
        "02:45",
        "03:00",
        "03:15",
        "03:30",
        "03:45",
        "04:00"
    );
    if ($servicio->obtenerServicios()) {
        $servicios = $servicio->obtenerServicios();
    }
    ?>
    <form action="<?php echo $_SERVER['PHP_SELF'] ?>?p=administracion" method="POST">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th class="text-danger" scope="col">SERVICIOS</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Tiempo necesario</th>
                </tr>
            </thead>
            <tbody>
            <?php
            if ($servicio->obtenerServicios()) {
                foreach ($servicios as $key => $value) {
                    ?>
                    <tr>
                    <?php
                    foreach ($value as $key2 => $value2){
                        if ($key2=="tiempo") {
                        ?>
                        <td>
                            <select name="<?php echo $key2.$value['id'] ?>">
                            <?php
                            foreach ($horas as $hora){
                                echo "<option value='$hora'";
                                if ($hora==substr($value2, 0, -3)) {
                                    echo "selected='selected'";
                                }
                                echo ">$hora</option>";
                            }
                            ?>
                            </select>
                        </td>
                        <?php
                        }else if ($key2!="id") {
                            ?>
                            <td><input type="text" name="<?php echo $key2.$value['id'] ?>" value="<?php echo $value2 ?>"></td>
                            <?php
                        }else{
                            ?>
                            <td><?php echo $value2 ?></td>
                            <?php
                        }
                    }
                    ?>
                    </tr>
                    <?php
                }
            }
            ?>
                <tr>
                    <td>Nuevo servicio:</td>
                    <td><input type="text" name="nombre" value=""></td>
                    <td>
                        <select name="tiempo">
                            <option value=""></option>
                            <?php
                            foreach ($horas as $hora){
                                ?>
                                <option value="<?php echo $hora ?>"><?php echo $hora ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </td>
                </tr>
            </tbody>
        </table>
        <input type="submit" name="añadirYModificarServicios" value="Añadir / Modificar servicios">
    </form>
    <?php
}
?>







    





</section>