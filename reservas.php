<?php
require "class/cita.php";
require "class/usuario.php";
//eliminar un servicio
function eliminarCita($id){
    $cita = new Cita($_SESSION['tipo'],$id);
    $cita->eliminarCita();
}
if(isset($_REQUEST["reserva"])){
    //require "class/cita.php";
    echo eliminarCita($_REQUEST["reserva"]);
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
?>
<h1>Mis reservas:</h1>
<section id="reservas">
    <article>
        aqui va la informacion de la reservas: fecha y hora de la cita.
    </article>
    <article>
        tambien tendrá a la derecha del todo una "x" o algo para cancelar la cita
    </article>
    <article>
        aqui estan mis reservas
        seguramente quitaré el article y lo dejaré a pelo en section
    </article>


    <article class="table-responsive">
    <?php
    $cita = new Cita($_SESSION['tipo']);
    //paginación
    $total = count($cita->obtenerCitas());
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
    if (!$cita->obtenerCitasPaginacion($inicio,$cuantos)) {
        ?>
        <div class="alert alert-warning centrarAlert" role="alert">
            <?php
            if ($_SESSION['tipo']=="Cliente") {
                ?>
                No hay ninguna reserva en su nombre. Creela.
                <?php
            }else{
                ?>
                No hay ninguna reserva disponible. Creela.
                <?php
            }
            ?>
        </div>
        <?php
        $citas = array();
    }else{
        $citas = $cita->obtenerCitasPaginacion($inicio,$cuantos);
    }
    ?>
    <table class="table table-hover">
        <thead>
            <tr>
                <th class="text-danger" scope="col">RESERVAS</th>
                <th scope="col">Motivos</th>
                <th scope="col">Fecha</th>
                <th scope="col">Tiempo necesario</th>
                <?php
                if ($_SESSION['tipo']!="Cliente") {
                    ?>
                    <th scope="col">Nombre usuario</th>
                    <?php
                }
                ?>
            </tr>
        </thead>
        <tbody>
    <?php
    if (count($citas)) {
        foreach ($citas as $key => $value) {
            ?>
            <tr>
            <?php
            foreach ($value as $key2 => $value2){
                if ($key2!="id_usuario") {
                    ?>
                    <td><?php echo $value2 ?></td>
                    <?php
                }else{
                    if ($_SESSION['tipo']!="Cliente") {
                        ?>
                        <td><?php echo $value2 ?></td>
                        <?php
                    }
                }
            }
            ?>
                <td>
                    <i class="far fa-file-pdf text-danger pdf"></i>
                </td>
                <td>
                    <i class="fas fa-trash-alt text-danger reserva"></i>
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
                    <a class="page-link" href="<?php echo $_SERVER['PHP_SELF'] ?>?p=reservas&inicioServicios=<?php echo $inicio-$cuantos ?>" <?php if ($inicio==0) { echo "tabindex='-1' aria-disabled='true'"; } ?>>Anteriores</a>
                </li>
                <?php
                for ($i=1; $i <= $paginas; $i++) {
                    ?>
                    <li class="page-item <?php if (ceil($inicio/$cuantos)+1==$i) { echo "active"; } ?>">
                        <a class="page-link" href="<?php echo $_SERVER['PHP_SELF'] ?>?p=reservas&inicioServicios=<?php echo $cuantos*($i-1) ?>"><?php echo $i ?></a>
                    </li>
                    <?php
                }
                ?>
                <li class="page-item <?php if ($inicio>=$total-$cuantos) { echo "disabled"; } ?>">
                    <a class="page-link" href="<?php echo $_SERVER['PHP_SELF'] ?>?p=reservas&inicioServicios=<?php echo $inicio+$cuantos ?>" <?php if ($inicio>=$total-$cuantos) { echo "tabindex='-1' aria-disabled='true'"; } ?>>Siguientes</a>
                </li>
            </ul>
        </nav>
        <?php
    }
    ?>
        <a href="<?php echo $_SERVER['PHP_SELF'] ?>?p=citas">Reserva una cita ahora</a>
    </article>
</section>