<?php
require "class/servicio.php";
?>
<section>
    <article>
    <article>
        <div id="datepicker"></div><!--$( ".selector" ).datepicker( "getDate" );      coge fecha-->
    </article>
    </article>
    <article id='verde'>
        <h1>Pedir cita</h1>
        <h2>Motivo/s:</h2>
        <form action="<?php echo $_SERVER['PHP_SELF'] ?>?p=citas" method="POST">
            <div id="motivos">
                <?php
                $servicio = new Servicio($_SESSION['tipo']);
                if (!$servicio->obtenerServicios()) {
                    if (isset($_POST['servicios'])) {
                        ?>
                        <div class="alert alert-warning centrarAlert" role="alert">
                            No hay ningún servicio disponible. Pongase en <a href="<?php echo $_SERVER['PHP_SELF'] ?>?p=contacto">contacto</a> con nosotros.
                        </div>
                        <?php
                        }
                    }else{
                        $servicios = $servicio->obtenerServicios();
                        foreach($servicios as $servicio){
                            ?>
                            <label><input type="checkbox" name="<?php echo $servicio['nombre'] ?>" value="<?php echo substr($servicio['tiempo'], 0, -3) ?>"><span><?php echo $servicio['nombre'] ?></span></label>
                            <?php
                        }
                    }
                ?>
            </div>
            <select name="" id="" disabled="disabled">
                <option value="">hora1</option>
                <option value="">hora2</option>
                <option value="">hora3</option>
            </select>
            <input type="submit" disabled="disabled" value="Confirmar">
        </form>
    </article>
</section>