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
            <!--navbar-expand-* es para el punto de ruptura-->
            <div class="container-fluid">
                <a class="navbar-brand" href="index.php">LOGO</a>
                <!--poner logo-->
                <button class="navbar-toggler btn btn-outline-danger" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false"
                    aria-label="Toggle navigation"><!--class='navbar-toggler '-->
                    <span class="navbar-toggler-icon"></span><!--class='navbar-toggler-icon '-->
                </button>
                <div id="navbarNavAltMarkup" class="collapse navbar-collapse text-danger derecha">
                    <div class="navbar-nav">
                        <!--no se si lo de text-danger sería mejor poner el color directamente en css-->
                        <a class="nav-link text-danger active" aria-current="page" href="index.php">Home</a>
                        <a class="nav-link text-danger" href="#">Features</a>
                        <a class="nav-link text-danger" href="#">Pricing</a>
                    </div>
                </div>
            </div>
        </nav>
        <!--CARRUSEL-->
        <div id="carouselExampleSlidesOnly" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="img/imagendeprueba.jpg" class="d-blockimg-fluid  w-100" alt="">
                    <!--class='img-fluid '-->
                </div>
                <div class="carousel-item">
                    <img src="img/imagendeprueba.jpg" class="d-block w-100" alt="">
                    <!--class='img-fluid '-->
                </div>
                <div class="carousel-item">
                    <img src="img/imagendeprueba.jpg" class="d-block w-100" alt="">
                    <!--class='img-fluid '-->
                </div>
            </div>
        </div>
    </header>
    <main class=".container-fluid">
        <h1 class="text-center">Servicios que se realizan:</h1>
        <section>
            <article>
                <h2 class="text-center">Cortes de pelo</h2>
                <img src="img/imagendeprueba.jpg" class="img-fluid" alt="">
                <p>Aquí realizamos distintos cortes de pelo, para más información dirijase a la página de <a href="contacto.php">contacto</a> y preguntenos.</p>
            </article>
            
            <article>
                <h2 class="text-center">Poner más servicios</h2>
                <img src="img/imagendeprueba.jpg" class="img-fluid" alt="">
                <p>Aquí realizamos distintos cortes de pelo, para más información dirijase a la página de <a href="contacto.php">contacto</a> y preguntenos.</p>
            </article>
        </section>
    </main>
    <footer class=".container-fluid bg-dark">
        <p>aqui va el pie de página</p>
    </footer>
</body>

</html>