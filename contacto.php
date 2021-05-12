<?php
require "class/usuario.php";
function validarDatos($datos){
    $msg = "";
    if (empty($datos['nombreCompleto'])||empty($datos['email'])||empty($datos['mensaje'])) {
        $msg = "Faltan datos por rellenar.";
    }else{
        if (!preg_match('/^[(a-z0-9\_\-\.)]+@[(a-z0-9\_\-\.)]+\.[(a-z)]{2,15}$/i',$datos['email'])) {
            $msg = "Formato email incorrecto.";
        }
    }
    return $msg;
}
$nombre = "";
$apellidos = "";//solo se usa para cargarlo automaticamente
$email = "";
$mensaje = "";
if (isset($_SESSION['id'])) {
    $usuario = new Usuario($_SESSION["id"],$_SESSION['tipo']);
    $usuario->recuperarDatos();
    $nombre = $usuario->get_nombre();
    $apellidos = $usuario->get_apellidos();
    $email = $usuario->get_email();
}
if (isset($_POST['enviar'])) {
    $nombre = htmlspecialchars(trim($_POST['nombreCompleto']));
    $email = htmlspecialchars(trim($_POST['email']));
    $mensaje = htmlspecialchars(trim($_POST['mensaje']));
    $msg = validarDatos($_POST);
    if (isset($msg)&&!empty($msg)) {
        ?>
        <div class="alert alert-danger centrarAlert" role="alert">
            <?php
            echo "$msg";
            ?>
        </div>
        <?php
    }else{
        //correo
        $to=$email;
        $asunto = "Consulta de $nombre";//modificar asunto
        $headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
		$headers .= "From: Peluquería Unisex 'La Gallega'<support@peluqueriaunisexlagallega.com>" . "\r\n";
		$headers .= "Cc: support@peluqueriaunisexlagallega.com" . "\r\n";
        $contenido = "
            <section>
                <p>Sr./Sra. <strong>$nombre</strong>,</p>
                <p>Esta es su consulta:</p>
                <p><strong>$mensaje</strong></p>
                <p>Gracias por contactar con nosotros. En breve recibirá una respuesta a su consulta.</p>
                <img src='".url_actual("correo")."/img/logo.png' alt='LOGO' width='10%'>
            </section>";
        //enviar correo
        if (mail($to,$asunto,$contenido,$headers)) {
            //correo enviado corectamente
            ?>
            <div class="alert alert-success centrarAlert" role="alert">
                El correo ha sido enviado correctamente. Si usted no recibe una copia en los proximos 5 minutos vuelva a escribirnos o pongase en contacto con nosotros por otra vía.
            </div>
        <?php
        }else{
            //el correo no se ha podido enviar
            ?>
            <div class="alert alert-danger centrarAlert" role="alert">
                El correo no ha sido enviado. Ha ocurrido un error. Vuelva a intentarlo o pongase en contacto con nosotros por otra via.
            </div>
            <?php
        }
    }
}
?>
<h1>Contacto:</h1>
<section id="contacto">
    <article id='verde'>
        <form action="<?php echo $_SERVER['PHP_SELF'] ?>?p=contacto" method="POST">
            <p>Nombre: <input type="text" name="nombreCompleto" value="<?php echo $nombre.' '.$apellidos ?>"></p>
            <p>E-mail: <input type="email" name="email" value="<?php echo $email ?>"></p>
            <p>Explique el motivo de su consulta:</p>
            <textarea name="mensaje" cols="30" rows="10"><?php echo $mensaje ?></textarea>
            <input type="submit" name="enviar" value="Enviar">
        </form>
    </article>
    <article id="misDatos">
        <p><strong>Correo:</strong> lagallega_ccg@hotmail.com</p>
        <p><strong>Teléfonos:</strong> 653235994 - 965488166</p>
        <div id="redesSociales">
            <a href="https://wa.link/gfmfwf"><img src="img/whatsapp-logo.png" alt="Whatsapp"></a>
            <a href="https://www.facebook.com/carmen.canto.14"><img src="img/facebook-logo.png" alt="Facebook"></a>
            <a href="https://instagram.com/peluqueria_lagallega"><img src="img/instagram-logo.png" alt="Instagram"></a>
        </div>
        <iframe id="mapa" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3136.428597363792!2d-0.8749901843990265!3d38.17671729670447!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd63bd04afc9d57d%3A0x12fc50e5cc3ee594!2sPeluquer%C3%ADa%20Unisex%20La%20Gallega!5e0!3m2!1ses!2ses!4v1616611886074!5m2!1ses!2ses" allowfullscreen="" loading="lazy"></iframe>
    </article>
</section>