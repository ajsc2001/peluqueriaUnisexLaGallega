<?php
require "class/usuario.php";
function validarDatos($datos){
    $msg = "";
    if (empty($datos['nombre'])||empty($datos['apellidos'])||empty($datos['edad'])||empty($datos['email'])||empty($datos['telefono'])||empty($datos['nick'])||empty($datos['contraseña'])||empty($datos['contraseña2'])) {
        $msg = "Faltan datos por rellenar.";
    }else{
        if (preg_match('/^[(a-z0-9\_\-\.)]+@[(a-z0-9\_\-\.)]+\.[(a-z)]{2,15}$/i',$datos['email'])) {
            if ($datos['contraseña']!=$datos['contraseña2']) {
                $msg = "No coinciden los passwords.";
            }
        }else{
            $msg = "Formato email incorrecto.";
        }
    }
    return $msg;
}
function eliminarUsuario(){
    $usuario = new Usuario("",$_SESSION['tipo']);
    $usuario->eliminarUsuario();
    session_unset();
}
if(isset($_REQUEST["condicion"])){
    if($_REQUEST["condicion"] == "eliminarUsuario" ){
       echo eliminarUsuario();
       exit();
    }
}else{
    //coger datos usuario
    $usuario = new Usuario($_SESSION["id"],$_SESSION['tipo']);
    $usuario->recuperarDatos();
    $nombre = $usuario->get_nombre();
    $apellidos = $usuario->get_apellidos();
    $edad = $usuario->get_edad();
    $email = $usuario->get_email();
    $telefono = $usuario->get_telefono();
    $nick = $usuario->get_nick();
    $contraseña = "";
    $contraseña2 = "";
    if (isset($_POST['modificar'])) {
        $nombre = htmlspecialchars(trim($_POST['nombre']));
	    $apellidos = htmlspecialchars(trim($_POST['apellidos']));
	    $edad = htmlspecialchars(trim($_POST['edad']));
	    $email = htmlspecialchars(trim($_POST['email']));
	    $telefono = htmlspecialchars(trim($_POST['telefono']));
	    $nick = htmlspecialchars(trim($_POST['nick']));
	    $contraseña = htmlspecialchars(trim($_POST['contraseña']));
	    $contraseña2 = htmlspecialchars(trim($_POST['contraseña2']));
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
		    if (isset($_POST['nick'])) {//si existe uno de los parametros que hay entonces creo user
			    $usuario = new Usuario($_SESSION["id"],$_SESSION["tipo"],$nick,$contraseña,$email,$telefono,$nombre,$apellidos,$edad);
			    if ($usuario->modificarUsuario()) {
                    //crear variables sesion
				    $_SESSION["id"] = $usuario->get_id();
				    $_SESSION["tipo"] = $usuario->get_tipo();
				    $_SESSION["nombre"] = $usuario->get_nombre();
				    ?>
				    <div class="alert alert-success centrarAlert" role="alert">
                        Datos del usuario modificados. Algunos de ellos serán visibles cuando realices la siguiente acción
				    </div>
				    <?php
			    }else{
				    ?>
				    <div class="alert alert-danger centrarAlert" role="alert">
                        Imposible modificar usuario, el email o el nombre de usuario esta siendo utilizado.
				    </div>
				    <?php
			    }
		    }
	    }
    }
}
?>
<h1>Mis datos:</h1>
<section id="cuenta">
    <article id="verde">
        <form action="<?php echo $_SERVER['PHP_SELF'] ?>?p=cuenta" method="POST">
            <p>Nombre: <input type="text" name="nombre" value="<?php echo $nombre ?>"></p>
            <p>Apellidos: <input type="text" name="apellidos" value="<?php echo $apellidos ?>"></p>
            <p>Edad: <input type="number" name="edad" value="<?php echo $edad ?>"></p>
            <p>E-mail: <input type="email" name="email" value="<?php echo $email ?>"></p>
            <p>Teléfono: <input type="text" name="telefono" value="<?php echo $telefono ?>"></p>
            <p>Nombre de usuario: <input type="text" name="nick" value="<?php echo $nick ?>"></p>
            <p>Contraseña: <input type="password" name="contraseña" value="<?php echo $contraseña ?>"></p>
            <p>Repetir contraseña: <input type="password" name="contraseña2" value="<?php echo $contraseña2 ?>"></p>
            <input type="submit" name="modificar" value="Modificar datos">
        </form>
    </article>
    <a id="eliminarUsuario" href="<?php echo $_SERVER['PHP_SELF'] ?>?p=cuenta">Eliminar cuenta</a>
</section>