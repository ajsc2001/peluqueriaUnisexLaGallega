<?php
    session_start();
    if (!isset($_SESSION["tipo"])) {
        $_SESSION["tipo"] = "root";
    }//poner else con los demas tipos de usuario
    require "lib/conexion.php";
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
            }else if (isset($_GET['p'])&& $_GET['p']=="administracion") {
                require "administracion.php";
            }else if (isset($_GET['p'])&& $_GET['p']=="logout") {
                echo "Cerrar sesión y redirigir a la HOME";
                //elimino todas las variables de sesion y creo unicamente el tipo
                session_unset();
				header("Location: index.php");
            }
        ?>
    </main>
<?php
    require "pie.php";
?>