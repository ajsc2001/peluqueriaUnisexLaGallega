<?php
require "class/usuario.php";
	function validarDatos($datos){
		if (empty($datos['nick'])||empty($datos['contraseña'])) {
			return false;
		}
		return true;
	}
	$nick = "";
	$contraseña = "";
	if (isset($_POST['login'])) {
		$nick = htmlspecialchars(trim($_POST['nick']));
		$contraseña = htmlspecialchars(trim($_POST['contraseña']));
		if (validarDatos($_POST)) {
			$usuario = new Usuario("",$_SESSION["tipo"],"","","","","",$nick,$contraseña);
			if ($usuario->existe()) {
                $usuario->login();
                //crear sesion del objeto
				$_SESSION["id"] = $usuario->get_id();
				$_SESSION["tipo"] = $usuario->get_tipo();
				$_SESSION["nombre"] = $usuario->get_nombre();
				header("Location: index.php");
			}else{
                ?>
				<div class="alert alert-danger centrarAlert" role="alert">
					<?php
					echo "LOGIN INCORRECTO";
					?>
				</div>
				<?php
            }
		}else{
            ?>
			<div class="alert alert-danger centrarAlert" role="alert">
				<?php
				echo "LOGIN INCORRECTO";
				?>
			</div>
			<?php
		}
	}
?>
<h1>Iniciar sesión:</h1>
<section id="login">
    <article id="verde">
        <form action="<?php echo $_SERVER['PHP_SELF'] ?>?p=login" method="POST">
            <p>Usuario: <input type="text" name="nick"></p>
            <p>Contraseña: <input type="password" name="contraseña"></p>
            <input type="submit" name="login" value="Log In">
        </form>
    </article>
    <a href="<?php echo $_SERVER['PHP_SELF'] ?>?p=crearUsuario">Crear usuario</a>
</section>