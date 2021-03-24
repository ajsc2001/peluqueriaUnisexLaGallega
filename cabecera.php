<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peluquería Unisex La Gallega</title>
    <!--Bootstrap 5.0.0-->
    <link rel="stylesheet" href="recursos/bootstrap5/css/bootstrap.min.css">
    <script src="recursos/bootstrap5/js/bootstrap.bundle.min.js"></script>
    <!--Mis archivos-->
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <header class=".container-fluid">
        <!--MENU-->
        <nav class="navbar navbar-expand-sm navbar-light margenes-menu">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.php"><img class="logo" src="" alt="LOGO"></a><!--poner clase logo en el 'a'-->
                <button class="navbar-toggler btn btn-outline-danger" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div id="navbarNavAltMarkup" class="collapse navbar-collapse text-danger derecha">
                    <div class="navbar-nav">
                    <!--mirar como ahcer para ponerlo todo dentro de un if (solo fanta una comilla que hay por en medio)-->
                        <a class="nav-link text-danger<?php if (!isset($_GET['p'])) {echo " active";} ?>" <?php if (!isset($_GET['p'])) {echo "aria-current='page'";} ?> href="<?php echo $_SERVER['PHP_SELF'] ?>">Home</a>
                        <a class="nav-link text-danger<?php if (isset($_GET['p'])&&$_GET['p']=="horario") {echo " active";} ?>" <?php if (isset($_GET['p'])&&$_GET['p']=="horario") {echo "aria-current='page'";} ?> href="<?php echo $_SERVER['PHP_SELF'] ?>?p=horario">Horario</a>
                        <a class="nav-link text-danger<?php if (isset($_GET['p'])&&$_GET['p']=="citas") {echo " active";} ?>" <?php if (isset($_GET['p'])&&$_GET['p']=="citas") {echo "aria-current='page'";} ?> href="<?php echo $_SERVER['PHP_SELF'] ?>?p=citas">Citas</a>
                        <a class="nav-link text-danger<?php if (isset($_GET['p'])&&$_GET['p']=="contacto") {echo " active";} ?>" <?php if (isset($_GET['p'])&&$_GET['p']=="contacto") {echo "aria-current='page'";} ?> href="<?php echo $_SERVER['PHP_SELF'] ?>?p=contacto">Contacto</a>
                        <a class="nav-link text-danger<?php if (isset($_GET['p'])&&$_GET['p']=="login") {echo " active";} ?>" <?php if (isset($_GET['p'])&&$_GET['p']=="login") {echo "aria-current='page'";} ?> href="<?php echo $_SERVER['PHP_SELF'] ?>?p=login">Log In</a>
                    </div>
                </div>
            </div>
        </nav>
        <!--CARRUSEL-->
        <div id="carouselExampleSlidesOnly" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="img/imagendeprueba.jpg" class="d-blockimg-fluid  w-100" alt="">
                </div>
                <div class="carousel-item">
                    <img src="img/imagendeprueba.jpg" class="d-block w-100" alt="">
                </div>
                <div class="carousel-item">
                    <img src="img/imagendeprueba.jpg" class="d-block w-100" alt="">
                </div>
            </div>
        </div>
    </header>