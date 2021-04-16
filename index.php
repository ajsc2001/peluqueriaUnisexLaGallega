<?php
    require "cabecera.php";
?>
    <main class=".container-fluid">
        <?php
            if (!isset($_GET['p'])) {
                require "home.php";
            }else if (isset($_GET['p'])&& $_GET['p']=="horario") {
                require "horario.php";
            }else if (isset($_GET['p'])&& $_GET['p']=="citas") {
                require "citas.php";
            }else if (isset($_GET['p'])&& $_GET['p']=="contacto") {
                require "contacto.php";
            }else if (isset($_GET['p'])&& $_GET['p']=="login") {
                require "login.php";
            }else if (isset($_GET['p'])&& $_GET['p']=="crearUsuario") {
                require "crearUsuario.php";
            }else if (isset($_GET['p'])&& $_GET['p']=="cuenta") {
                require "cuenta.php";
            }else if (isset($_GET['p'])&& $_GET['p']=="reservas") {
                require "reservas.php";
            }else if (isset($_GET['p'])&& $_GET['p']=="logout") {
                echo "Cerrar sesión y redirigir a la HOME";
                //require "logout.php";
            }
        ?>
    </main>
<?php
    require "pie.php";
?>