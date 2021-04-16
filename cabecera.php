<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="img/favicon.ico">
    <title>Peluquería Unisex "La Gallega"</title>
    <!--Bootstrap 5.0.0-->
    <link rel="stylesheet" href="recursos/bootstrap5/css/bootstrap.min.css">
    <script src="recursos/bootstrap5/js/bootstrap.bundle.min.js"></script>
    <!--jQuery 3.6.0-->
    <script src="recursos/jquery-3.6.0.min.js"></script>
<!--Calendario-->
<?php
if (isset($_GET['p'])&&($_GET['p']=="horario"||$_GET['p']=="citas")) {
    ?>
    <!--jQuery UI 1.12.1-->
    <link rel="stylesheet" href="recursos/jquery-ui-1.12.1/jquery-ui.min.css">
    <script src="recursos/jquery-ui-1.12.1/jquery-ui.min.js"></script>
    <script src="recursos/calendario.js"></script>
    <?php
}
?>
    <!--Mis archivos-->
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <header class=".container-fluid">
        <!--MENU-->
        <nav class="navbar navbar-expand-sm navbar-light margenes-menu">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.php"><img class="logo" src="img/logo.png" alt="LOGO"></a><!--poner clase logo en el 'a'-->
                <button class="navbar-toggler btn btn-outline-danger" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div id="navbarNavDropdown" class="collapse navbar-collapse text-danger derecha">
                    <ul class="navbar-nav"><!--mirar como ahcer para ponerlo todo dentro de un if (solo falta una comilla que hay por en medio)-->
                        <li class="nav-item">
                            <a class="nav-link text-danger<?php if (!isset($_GET['p'])) {echo " active";} ?>" <?php if (!isset($_GET['p'])) {echo "aria-current='page'";} ?> href="<?php echo $_SERVER['PHP_SELF'] ?>">Inicio</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-danger<?php if (isset($_GET['p'])&&$_GET['p']=="horario") {echo " active";} ?>" <?php if (isset($_GET['p'])&&$_GET['p']=="horario") {echo "aria-current='page'";} ?> href="<?php echo $_SERVER['PHP_SELF'] ?>?p=horario">Horario</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-danger<?php if (isset($_GET['p'])&&$_GET['p']=="citas") {echo " active";} ?>" <?php if (isset($_GET['p'])&&$_GET['p']=="citas") {echo "aria-current='page'";} ?> href="<?php echo $_SERVER['PHP_SELF'] ?>?p=citas">Citas</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-danger<?php if (isset($_GET['p'])&&$_GET['p']=="contacto") {echo " active";} ?>" <?php if (isset($_GET['p'])&&$_GET['p']=="contacto") {echo "aria-current='page'";} ?> href="<?php echo $_SERVER['PHP_SELF'] ?>?p=contacto">Contacto</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-danger<?php if (isset($_GET['p'])&&$_GET['p']=="login") {echo " active";} ?>" <?php if (isset($_GET['p'])&&$_GET['p']=="login") {echo "aria-current='page'";} ?> href="<?php echo $_SERVER['PHP_SELF'] ?>?p=login">Iniciar sesión</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-danger" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">Hola, <strong>{NOMBRE}</strong></a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <li><a class="dropdown-item text-danger<?php if (isset($_GET['p'])&&$_GET['p']=="cuenta") {echo " active";} ?>" <?php if (isset($_GET['p'])&&$_GET['p']=="cuenta") {echo "aria-current='page'";} ?> href="<?php echo $_SERVER['PHP_SELF'] ?>?p=cuenta">Mi cuenta</a></li>
                                <li><a class="dropdown-item text-danger<?php if (isset($_GET['p'])&&$_GET['p']=="reservas") {echo " active";} ?>" <?php if (isset($_GET['p'])&&$_GET['p']=="reservas") {echo "aria-current='page'";} ?> href="<?php echo $_SERVER['PHP_SELF'] ?>?p=reservas">Mis reservas</a></li>
                                <li><a class="dropdown-item text-danger<?php if (isset($_GET['p'])&&$_GET['p']=="logout") {echo " active";} ?>" <?php if (isset($_GET['p'])&&$_GET['p']=="logout") {echo "aria-current='page'";} ?> href="<?php echo $_SERVER['PHP_SELF'] ?>?p=logout">Cerrar sesión</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <!--CARRUSEL-->
        <div id="carouselExampleSlidesOnly" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="img/carrusel1.jpeg" class="d-block w-100" alt="">
                </div>
                <div class="carousel-item">
                    <img src="img/carrusel2.jpeg" class="d-block w-100" alt="">
                </div>
                <div class="carousel-item">
                    <img src="img/carrusel3.jpeg" class="d-block w-100" alt="">
                </div>
                <div class="carousel-item">
                    <img src="img/carrusel4.jpeg" class="d-block w-100" alt="">
                </div>
                <div class="carousel-item">
                    <img src="img/carrusel5.jpeg" class="d-block w-100" alt="">
                </div>
            </div>
        </div>
    </header>