    <footer class=".container-fluid bg-dark">
        <div id="menus">
            <nav class="nav flex-column">
                <a class="nav-link<?php if (!isset($_GET['p'])) {echo " active";} ?>" <?php if (!isset($_GET['p'])) {echo "aria-current='page'";} ?> href="<?php echo $_SERVER['PHP_SELF'] ?>">Inicio</a>
                <a class="nav-link<?php if (isset($_GET['p'])&&$_GET['p']=="horario") {echo " active";} ?>" <?php if (isset($_GET['p'])&&$_GET['p']=="horario") {echo "aria-current='page'";} ?> href="<?php echo $_SERVER['PHP_SELF'] ?>?p=horario">Horario</a>
                <a class="nav-link<?php if (isset($_GET['p'])&&$_GET['p']=="citas") {echo " active";} ?>" <?php if (isset($_GET['p'])&&$_GET['p']=="citas") {echo "aria-current='page'";} ?> href="<?php echo $_SERVER['PHP_SELF'] ?>?p=citas">Citas</a>
                <a class="nav-link<?php if (isset($_GET['p'])&&$_GET['p']=="contacto") {echo " active";} ?>" <?php if (isset($_GET['p'])&&$_GET['p']=="contacto") {echo "aria-current='page'";} ?> href="<?php echo $_SERVER['PHP_SELF'] ?>?p=contacto">Contacto</a>
                <?php
                if (!isset($_SESSION["nombre"])) {
                    ?>
                    <a class="nav-link<?php if (isset($_GET['p'])&&$_GET['p']=="login") {echo " active";} ?>" <?php if (isset($_GET['p'])&&$_GET['p']=="login") {echo "aria-current='page'";} ?> href="<?php echo $_SERVER['PHP_SELF'] ?>?p=login">Iniciar sesión</a>
            </nav>
                    <?php
                }else{
                    if (isset($_SESSION['tipo'])&&$_SESSION['tipo']=="Administrador") {
                        ?>
            </nav>
            <nav class="nav flex-column">
                        <a class="nav-link<?php if (isset($_GET['p'])&&$_GET['p']=="administracion") {echo " active";} ?>" <?php if (isset($_GET['p'])&&$_GET['p']=="administracion") {echo "aria-current='page'";} ?> href="<?php echo $_SERVER['PHP_SELF'] ?>?p=administracion">Administración</a>
                        <?php
                    }
                    ?>
                    <a class="nav-link<?php if (isset($_GET['p'])&&$_GET['p']=="cuenta") {echo " active";} ?>" <?php if (isset($_GET['p'])&&$_GET['p']=="cuenta") {echo "aria-current='page'";} ?> href="<?php echo $_SERVER['PHP_SELF'] ?>?p=cuenta">Mi cuenta</a>
                    <a class="nav-link<?php if (isset($_GET['p'])&&$_GET['p']=="reservas") {echo " active";} ?>" <?php if (isset($_GET['p'])&&$_GET['p']=="reservas") {echo "aria-current='page'";} ?> href="<?php echo $_SERVER['PHP_SELF'] ?>?p=reservas">Mis reservas</a></li>
                    <a class="nav-link<?php if (isset($_GET['p'])&&$_GET['p']=="logout") {echo " active";} ?>" <?php if (isset($_GET['p'])&&$_GET['p']=="logout") {echo "aria-current='page'";} ?> href="<?php echo $_SERVER['PHP_SELF'] ?>?p=logout">Cerrar sesión</a></li>
                    <?php
                }
                ?>
            </nav>
        </div>
        <section class="logo">
            <img src="img/logo.png" alt="LOGO">
        </section>
        <section id="redesSociales">
            <a href="https://wa.link/gfmfwf"><img src="img/whatsapp-logo.png" alt="Whatsapp"></a>
            <a href="https://www.facebook.com/carmen.canto.14"><img src="img/facebook-logo.png" alt="Facebook"></a>
            <a href="https://instagram.com/peluqueria_lagallega"><img src="img/instagram-logo.png" alt="Instagram"></a>
        </section>
    </footer>
</body>

</html>