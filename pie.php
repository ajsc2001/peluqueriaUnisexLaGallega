    <footer class=".container-fluid bg-dark">
        <nav class="nav flex-column">
            <a class="nav-link<?php if (!isset($_GET['p'])) {echo " active";} ?>" <?php if (!isset($_GET['p'])) {echo "aria-current='page'";} ?> href="<?php echo $_SERVER['PHP_SELF'] ?>">Home</a>
            <a class="nav-link<?php if (isset($_GET['p'])&&$_GET['p']=="horario") {echo " active";} ?>" <?php if (isset($_GET['p'])&&$_GET['p']=="horario") {echo "aria-current='page'";} ?> href="<?php echo $_SERVER['PHP_SELF'] ?>?p=horario">Horario</a>
            <a class="nav-link<?php if (isset($_GET['p'])&&$_GET['p']=="citas") {echo " active";} ?>" <?php if (isset($_GET['p'])&&$_GET['p']=="citas") {echo "aria-current='page'";} ?> href="<?php echo $_SERVER['PHP_SELF'] ?>?p=citas">Citas</a>
            <a class="nav-link<?php if (isset($_GET['p'])&&$_GET['p']=="contacto") {echo " active";} ?>" <?php if (isset($_GET['p'])&&$_GET['p']=="contacto") {echo "aria-current='page'";} ?> href="<?php echo $_SERVER['PHP_SELF'] ?>?p=contacto">Contacto</a>
            <a class="nav-link<?php if (isset($_GET['p'])&&$_GET['p']=="login") {echo " active";} ?>" <?php if (isset($_GET['p'])&&$_GET['p']=="login") {echo "aria-current='page'";} ?> href="<?php echo $_SERVER['PHP_SELF'] ?>?p=login">Log In</a>
        </nav>
        <section class="logo">
            <img src="img/logo.png" alt="LOGO">
        </section>
        <section id="redesSociales">
            <a href=""><img src="img/whatsapp-logo.png" alt="Whatsapp"></a>
            <a href=""><img src="img/facebook-logo.png" alt="Facebook"></a>
            <a href=""><img src="img/instagram-logo.png" alt="Instagram"></a>
        </section>
    </footer>
    <!--poner por alguna parte algo de copyright-->
</body>

</html>