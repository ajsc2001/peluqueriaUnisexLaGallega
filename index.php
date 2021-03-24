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
            }
        ?>
    </main>
<?php
    require "pie.php";
?>