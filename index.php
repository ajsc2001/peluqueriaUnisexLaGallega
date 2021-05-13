<?php
    session_start();
    ob_start();
    if (!isset($_SESSION["tipo"])) {
        $_SESSION["tipo"] = "Cliente";
    }
    require "lib/conexion.php";
    require "cabecera.php";
?>
    <main class="container-fluid">
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
                if (!isset($_SESSION['id'])) {
                    header("Location: index.php?p=login");
                }else{
                    require "cuenta.php";
                }
            }else if (isset($_GET['p'])&& $_GET['p']=="reservas") {
                if (!isset($_SESSION['id'])) {
                    header("Location: index.php?p=login");
                }else{
                    require "reservas.php";
                }
            }else if (isset($_GET['p'])&& $_GET['p']=="administracion") {
                if (isset($_SESSION['tipo'])&&$_SESSION['tipo']!="Administrador") {
                    header("Location: index.php");
                }else{
                    require "administracion.php";
                }
            }else if (isset($_GET['p'])&& $_GET['p']=="logout") {
                if (!isset($_SESSION['id'])) {
                    header("Location: index.php?p=login");
                }else{
                    //elimino todas las variables de sesion y creo unicamente el tipo al redirigir al index.php
                    session_unset();
				    header("Location: index.php");
                }
            }
        ?>
    </main>
<?php
    require "pie.php";
    ob_end_flush();
?>