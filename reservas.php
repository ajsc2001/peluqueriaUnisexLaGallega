<?php
require "class/cita.php";
require "class/usuario.php";
////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////AJAX////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////
//eliminar un servicio
function eliminarCita($id){
    $cita = new Cita($_SESSION['tipo'],$id);
    $cita->eliminarCita();
}
if(isset($_REQUEST["reserva"])){
    //require "class/cita.php";
    echo eliminarCita($_REQUEST["reserva"]);
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
////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////RESERVAS//////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////
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
    <?php
    $cita = new Cita($_SESSION['tipo']);
    //paginación
    if (isset($_SESSION['paginaActual'])) {
        $inicio = $_SESSION['paginaActual'] * $cuantos - $cuantos;
    }else{
        if (isset($_GET['inicioUsuarios'])) {
            $inicio = $_GET['inicioUsuarios'];
        }else{
            $inicio = 0;
        }
    }
    $total = count($cita->obtenerCitasPaginacion($inicio,$cuantos));
    $paginas = ceil($total/$cuantos);
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
    if (count($citas)) {
    ?>
<div class="table-responsive">
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
        foreach ($citas as $key => $value) {
            ?>
            <tr>
            <?php
            foreach ($value as $key2 => $value2){
                if ($key2=="tiempo"||$key2=="fecha") {
                    ?>
                    <td><?php echo substr($value2,0,-3) ?></td>
                    <?php
                }else if($key2=="id_usuario"){
                    if (isset($_SESSION['tipo'])&&$_SESSION['tipo']!="Cliente") {
                        $usuario = new Usuario($value2,$_SESSION['tipo']);
                        $usuario->recuperarDatos();
                        $nombre = $usuario->get_nombre();
                        $apellidos = $usuario->get_apellidos();
                        ?>
                        <td><?php echo "$nombre $apellidos" ?></td>
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
                    <a target="_blank" href="lib/generarPDF.php?id=<?php echo $citas[$key]['id'] ?>"><i class="far fa-file-pdf text-danger pdf"></i></a>
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
</div>
    <?php
    //paginación
    if ($paginas>0) {
        ?>
        <div id="pagination">
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
        </div>
        <?php
    }
    ?>
        <a href="<?php echo $_SERVER['PHP_SELF'] ?>?p=citas">Reserva una cita ahora</a>
    </article>
</section>