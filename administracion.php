<?php
////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////AJAX////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////
//eliminar un usuario
function eliminarUsuario($id){
    $usuario = new Usuario($id,$_SESSION['tipo']);
    $usuario->eliminarUsuario();
    if ($id==$_SESSION['id']) {
        header("Location: index.php?p=logout");
    }
}
if(isset($_REQUEST["usuario"])){
    require "class/usuario.php";
    echo eliminarUsuario($_REQUEST["usuario"]);
    //echo array_push($_POST,"usuarios"=>"");
    exit();
}
//eliminar un servicio
function eliminarServicio($id){
    $servicio = new Servicio($_SESSION['tipo'],$id);
    $servicio->eliminarServicio();
}
if(isset($_REQUEST["servicio"])){
    require "class/servicio.php";
    echo eliminarServicio($_REQUEST["servicio"]);
    //echo array_push($_POST,"servicios"=>"");
    exit();
}
//eliminar la página actual en la que esto (paginación)
function eliminarPaginaActual(){
    if (isset($_SESSION['paginaActual'])) {
        unset($_SESSION['paginaActual']);
    }
}
if (isset($_REQUEST['condicion'])&&$_REQUEST['condicion']=="eliminarPaginaActual") {
    //elimino la sesion de la pagina actual
    echo eliminarPaginaActual();
}
//paginacion
$cuantos = 10;
if(isset($_REQUEST["paginaActual"])){
    echo $_SESSION['paginaActual'] = $_REQUEST['paginaActual'];
    exit();
}
////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////Botones/////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////
if (isset($_POST['usuarios'])||isset($_POST['modificarUsuarios'])||isset($_GET['inicioUsuarios'])) {
    require "class/usuario.php";
}
if (isset($_POST['servicios'])||isset($_POST['añadirYModificarServicios'])||isset($_GET['inicioServicios'])) {
    require "class/servicio.php";
}
if (isset($_POST['horarios'])||isset($_POST['modificarHorario'])) {
    require "class/horario.php";
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
////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////Tabla usuarios////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////
if (isset($_POST['usuarios'])||isset($_POST['modificarUsuarios'])||isset($_GET['inicioUsuarios'])) {
    $usuario = new Usuario("",$_SESSION['tipo']);
    //paginación
    $total = count($usuario->obtenerUsuarios());
    $paginas = ceil($total/$cuantos);
    if (isset($_SESSION['paginaActual'])) {
        $inicio = $_SESSION['paginaActual'] * $cuantos - $cuantos;
    }else{
        if (isset($_GET['inicioUsuarios'])) {
            $inicio = $_GET['inicioUsuarios'];
        }else{
            $inicio = 0;
        }
    }
    if ($usuario->obtenerUsuariosPaginacion($inicio,$cuantos)) {
        $usuarios = $usuario->obtenerUsuariosPaginacion($inicio,$cuantos);
    }
    if (isset($_POST['modificarUsuarios'])) {
        function validarDatos($datos){
            foreach($datos as $key => $value){
                if (substr($key,0,11)!="contraseña"&&empty($value)) {
                    return false;
                }
            }
            return true;
        }
        //htmlspecialcharts y trim de $_POST
        foreach($_POST as $key => $value){
            $_POST[$key] = htmlspecialchars(trim($value));
        }
        //me quedo el array sin el dato del boton
        $datos_usr = array_slice($_POST, 0, -1);
        if (!validarDatos($_POST)) {
            ?>
            <div class="alert alert-danger centrarAlert" role="alert">
                Para modificar los datos de los usuarioas solo puede dejar sin rellenar la contraseña en cuyo caso no será actualizada.
            </div>
            <?php
        }else{
            $msg = "Los datos de los usuarios han sido modificados";
            $err = false;
            for ($i=0; $i < count($usuarios); $i++) {
                $usuario = new Usuario($usuarios[$i]['id'],array_shift($datos_usr),array_shift($datos_usr),array_shift($datos_usr),array_shift($datos_usr),array_shift($datos_usr),array_shift($datos_usr),array_shift($datos_usr),array_shift($datos_usr));
                if (!$usuario->modificarUsuario()) {
                    $err = true;
                    $msg .= " pero alguna/s de las modificaciones que ha hecho no se han llevado a cabo por que algún usuario ya usaba o el email o el nick";
                }
            }
            if ($err) {
                ?>
                <div class="alert alert-warning centrarAlert" role="alert">
                    <?php echo $msg ?>.
                </div>
                <?php
            }else{
                ?>
                <div class="alert alert-success centrarAlert" role="alert">
                    <?php echo $msg ?>.
                </div>
                <?php
            }
        }
    }
    //datos
    $tipos_usr = array(
        "Administrador",
        "Trabajador",
        "Cliente"
    );
    $usuario = new Usuario("",$_SESSION['tipo']);
    if ($usuario->obtenerUsuariosPaginacion($inicio,$cuantos)) {
        $usuarios = $usuario->obtenerUsuariosPaginacion($inicio,$cuantos);
    }
    ?>
    <form action="<?php echo $_SERVER['PHP_SELF'] ?>?p=administracion" method="POST">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th class="text-danger" scope="col">USUARIOS</th>
                    <th scope="col">Tipo</th>
                    <th scope="col">Nick</th>
                    <th scope="col">Contraseña</th>
                    <th scope="col">Email</th>
                    <th scope="col">Telefono</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Apellidos</th>
                    <th scope="col">Edad</th>
                </tr>
            </thead>
            <tbody>
            <?php
            if (/*$usuario->obtenerUsuarios()*/count($usuarios)) {
                foreach ($usuarios as $key => $value) {
                    ?>
                    <tr>
                    <?php
                    foreach ($value as $key2 => $value2){
                        if ($key2!="id") {
                            if ($key2=="tipo") {
                            ?>
                            <td>
                                <select id="<?php echo $value['id'] ?>" name="<?php echo $key2.$value['id'] ?>">
                                <?php
                                foreach ($tipos_usr as $tipo){
                                    echo "<option value='$tipo'";
                                    if ($tipo==$value2) {
                                        echo "selected='selected'";
                                    }
                                    echo ">$tipo</option>";
                                }
                                ?>
                                </select>
                            </td>
                            <?php
                            }else if($key2=="contraseña"){
                                ?>
                                <td><input type="password" name="<?php echo $key2.$value['id'] ?>" value=""></td>
                                <?php
                            }else if($key2=="edad"){
                                ?>
                                <td><input type="number" name="<?php echo $key2.$value['id'] ?>" value="<?php echo $value2 ?>"></td>
                                <?php
                            }else{
                                ?>
                                <td><input type="text" name="<?php echo $key2.$value['id'] ?>" value="<?php echo $value2 ?>"></td>
                                <?php
                            }
                        }else{
                            ?>
                            <td><?php echo $value2 ?></td>
                            <?php
                        }
                    }
                    ?>
                        <td>
                            <i class="fas fa-trash-alt text-danger usuario"></i>
                        </td>
                    </tr>
                    <?php
                }
            }
            ?>
            </tbody>
        </table>
        <?php
        //paginación
        if ($paginas>0) {
            ?>
            <nav id="paginacion" aria-label="...">
                <ul class="pagination">
                    <li class="page-item <?php if ($inicio==0) { echo "disabled"; } ?>">
                        <a class="page-link" href="<?php echo $_SERVER['PHP_SELF'] ?>?p=administracion&inicioUsuarios=<?php echo $inicio-$cuantos ?>" <?php if ($inicio==0) { echo "tabindex='-1' aria-disabled='true'"; } ?>>Anteriores</a>
                    </li>
                    <?php
                    for ($i=1; $i <= $paginas; $i++) {
                        ?>
                        <li class="page-item <?php if (ceil($inicio/$cuantos)+1==$i) { echo "active"; } ?>">
                            <a class="page-link" href="<?php echo $_SERVER['PHP_SELF'] ?>?p=administracion&inicioUsuarios=<?php echo $cuantos*($i-1) ?>"><?php echo $i ?></a>
                        </li>
                        <?php
                    }
                    ?>
                    <li class="page-item <?php if ($inicio>=$total-$cuantos) { echo "disabled"; } ?>">
                        <a class="page-link" href="<?php echo $_SERVER['PHP_SELF'] ?>?p=administracion&inicioUsuarios=<?php echo $inicio+$cuantos ?>" <?php if ($inicio>=$total-$cuantos) { echo "tabindex='-1' aria-disabled='true'"; } ?>>Siguientes</a>
                    </li>
                </ul>
            </nav>
            <?php
        }
        ?>
        <input type="submit" name="modificarUsuarios" value="Modificar usuarios">
        <a href="<?php echo $_SERVER['PHP_SELF'] ?>?p=crearUsuario">Crear usuario</a>
    </form>
    <?php
}
////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////Tabla servicios////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////
if (isset($_POST['servicios'])||isset($_POST['añadirYModificarServicios'])||isset($_GET['inicioServicios'])) {
    $servicio = new Servicio($_SESSION['tipo']);
    //paginación
    $total = count($servicio->obtenerServicios());
    $paginas = ceil($total/$cuantos);
    if (isset($_SESSION['paginaActual'])) {
        $inicio = $_SESSION['paginaActual'] * $cuantos - $cuantos;
    }else{
        if (isset($_GET['inicioServicios'])) {
            $inicio = $_GET['inicioServicios'];
        }else{
            $inicio = 0;
        }
    }
    //servicios paginados
    if (!$servicio->obtenerServiciosPaginacion($inicio,$cuantos)) {
        if (isset($_POST['servicios'])) {
            ?>
            <div class="alert alert-warning centrarAlert" role="alert">
                No hay ningún servicio disponible. Creelo.
            </div>
            <?php
        }
    }else{
        $servicios = $servicio->obtenerServiciosPaginacion($inicio,$cuantos);
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
            return $cont;
        }
        //htmlspecialcharts y trim de $_POST
        foreach($_POST as $key => $value){
            $_POST[$key] = htmlspecialchars(trim($value));
        }
        //divido el array en existentes y nuevos
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
            if ($nuevos!=0&&$nuevos!=count($serviciosNuevos)) {
                ?>
                <div class="alert alert-danger centrarAlert" role="alert">
                    Si rellena un campo de la última fila tiene que rellenar el resto de campos. Revise todos los campos que haya modificado.
                </div>
                <?php
            }else{
                $err = false;
                $msg = "";
                if ($servicio->obtenerServiciosPaginacion($inicio,$cuantos)) {//paginados????
                    $msg .= "Los datos de servicios anteriores han sido actualizados";
                    //modifico los ya existentes
                    for ($i=0; $i < count($servicios); $i++) { 
                        $servicio = new Servicio($_SESSION['tipo'],$servicios[$i]['id'],array_shift($serviciosExistentes),array_shift($serviciosExistentes));
                        if (!$servicio->modificarServicio()) {
                            $err = true;
                        }
                    }
                    if ($err) {
                        $msg .= " pero algun/os servicios que ha modificado ya existian por lo que no han sido modificados";
                    }
                }
                if ($nuevos==0) {
                    //creo el nuevo servicio
                    $servicio = new Servicio($_SESSION['tipo'],"",array_shift($serviciosNuevos),array_shift($serviciosNuevos));
                    if ($servicio->nuevoServicio()) {
                        if (strlen($msg)) {
                            $msg .= " y se ha añadido un nuevo servicio.";
                        }else{
                            $msg .= "Se ha añadido un nuevo servicio.";
                        }
                        if ($err) {
                            ?>
                            <div class="alert alert-warning centrarAlert" role="alert">
                                <?php
                                echo $msg;
                                ?>
                            </div>
                            <?php
                        }else{
                            ?>
                            <div class="alert alert-success centrarAlert" role="alert">
                                <?php
                                echo $msg;
                                ?>
                            </div>
                            <?php
                        }
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
                }else{
                    if ($err) {
                        ?>
                        <div class="alert alert-warning centrarAlert" role="alert">
				            <?php
                            echo $msg;
                            ?>
                        </div>
                        <?php
                    }else{
                        ?>
                        <div class="alert alert-success centrarAlert" role="alert">
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
    function llenarHoras(){
        $horas = array();
        $hora = 0;
        $minutos = 0;
        $cadena = str_pad($hora, 2, "0", STR_PAD_LEFT).":".str_pad($minutos, 2, "0", STR_PAD_LEFT);
        array_push($horas,$cadena);
        while ($cadena != "04:00") {
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
    //datos
    $horas = llenarHoras();
    if ($servicio->obtenerServiciosPaginacion($inicio,$cuantos)) {
        $servicios = $servicio->obtenerServiciosPaginacion($inicio,$cuantos);
    }else{
        //si no hay servicios creo array vacio para que depsues en el for no de error
        $servicios = array();
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
            if (/*$servicio->obtenerServicios()*/count($servicios)) {
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
                        <td>
                            <i class="fas fa-trash-alt text-danger servicio"></i>
                        </td>
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
        <?php
        //paginación
        if ($paginas>0) {
            ?>
            <nav id="paginacion" aria-label="...">
                <ul class="pagination">
                    <li class="page-item <?php if ($inicio==0) { echo "disabled"; } ?>">
                        <a class="page-link" href="<?php echo $_SERVER['PHP_SELF'] ?>?p=administracion&inicioServicios=<?php echo $inicio-$cuantos ?>" <?php if ($inicio==0) { echo "tabindex='-1' aria-disabled='true'"; } ?>>Anteriores</a>
                    </li>
                    <?php
                    for ($i=1; $i <= $paginas; $i++) {
                        ?>
                        <li class="page-item <?php if (ceil($inicio/$cuantos)+1==$i) { echo "active"; } ?>">
                            <a class="page-link" href="<?php echo $_SERVER['PHP_SELF'] ?>?p=administracion&inicioServicios=<?php echo $cuantos*($i-1) ?>"><?php echo $i ?></a>
                        </li>
                        <?php
                    }
                    ?>
                    <li class="page-item <?php if ($inicio>=$total-$cuantos) { echo "disabled"; } ?>">
                        <a class="page-link" href="<?php echo $_SERVER['PHP_SELF'] ?>?p=administracion&inicioServicios=<?php echo $inicio+$cuantos ?>" <?php if ($inicio>=$total-$cuantos) { echo "tabindex='-1' aria-disabled='true'"; } ?>>Siguientes</a>
                    </li>
                </ul>
            </nav>
            <?php
        }
        ?>
        <input type="submit" name="añadirYModificarServicios" value="Añadir / Modificar servicios">
    </form>
    <?php
}
////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////Tabla horario////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////
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
    $horario = new Horario($_SESSION['tipo'],$semana['Lunes'],$semana['Martes'],$semana['Miércoles'],$semana['Jueves'],$semana['Viernes'],$semana['Sábado'],$semana['Domingo']);
    $horario->modificarDias();
    ?>
    <div class="alert alert-success centrarAlert" role="alert">
        El horario ha sido modificado.
    </div>
    <?php
}
if (isset($_POST['horarios'])||isset($_POST['modificarHorario'])) {
    function llenarHoras(){
        $horas = array();
        $hora = 8;
        $minutos = 0;
        $cadena = str_pad($hora, 2, "0", STR_PAD_LEFT).":".str_pad($minutos, 2, "0", STR_PAD_LEFT);
        array_push($horas,$cadena);
        while ($cadena != "22:00") {
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
    //datos
    $horas = llenarHoras();
    $horario = new Horario($_SESSION['tipo']);
    if ($horario->obtenerDias()) {
        ?>
        <div class="alert alert-warning centrarAlert" role="alert">
            No habia ningún horario disponible. El horario ha sido creado.
        </div>
        <?php
    }
    $semana = array(
        "Lunes" => $horario->get_lunes(),
        "Martes" => $horario->get_martes(),
        "Miercoles" => $horario->get_miercoles(),
        "Jueves" => $horario->get_jueves(),
        "Viernes" => $horario->get_viernes(),
        "Sabado" => $horario->get_sabado(),
        "Domingo" => $horario->get_domingo()
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
?>
</section>