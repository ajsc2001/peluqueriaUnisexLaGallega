<?php
function url_actual($donde){
	if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
	  $url = "https://"; 
	}else{
	  $url = "http://"; 
	}
	if($donde=="clase"){//como uso esta funcion desde 2 paginas distintas, en una me hace falta la url completa y en otra no, por lo que envio una variable a la funcion apra saber de que caso se trata
	    return $url . $_SERVER['HTTP_HOST'] .  $_SERVER['REQUEST_URI'];
	}else{
	    return $url.$_SERVER['HTTP_HOST'];
	}
}
if (strpos(url_actual("clase"),"id")) {
	require "codificacion.php";
}else{
	require "lib/codificacion.php";
}
	Class Usuario{
		private $id;
		private $tipo;
		private $nick;
		private $contraseña;
		private $email;
		private $telefono;
		private $nombre;
		private $apellidos;
		private $edad;
		function __construct($id="",$tipo="Cliente",$nick="",$contraseña="",$email="",$telefono="",$nombre="",$apellidos="",$edad=""){
			$this->id = $id;
			$this->tipo = $tipo;
			$this->nombre = $nombre;
			$this->apellidos = $apellidos;
			$this->edad = $edad;
			$this->email = $email;
			$this->telefono = $telefono;
			$this->nick = $nick;
			$this->contraseña = $contraseña;
		}
		function get_id(){
			return $this->id;
		}
		function get_tipo(){
			return $this->tipo;
		}
		function get_nombre(){
			return $this->nombre;
		}
		function get_apellidos(){
			return $this->apellidos;
		}
		function get_edad(){
			return $this->edad;
		}
		function get_email(){
			return $this->email;
		}
		function get_telefono(){
			return $this->telefono;
		}
		function get_nick(){
			return $this->nick;
		}
		function crearUsuario(){
			$usuarios = $this->obtenerUsuarios();
			if (!count($usuarios)<1) {
				$conexion = Conexion::conectarBD($this->tipo);
				$sql = "SELECT * FROM usuarios WHERE email='$this->email' OR nick='$this->nick'";
				if ($result = $conexion->query($sql)) {
					if ($result->num_rows<1) {
						$this->añadirUsuario();
						return true;
					}else{
						return false;
					}
				}
				$result->free();
				Conexion::desconectarBD($conexion);
			}else{
				$this->tipo = "Administrador";
				$this->añadirUsuario();
				return true;
			}
		}
		function añadirUsuario(){
			$conexion = Conexion::conectarBD($this->tipo);
			$sql = "INSERT INTO usuarios (tipo, nick, contraseña, email, telefono, nombre, apellidos, edad) VALUES ('$this->tipo', '$this->nick', '".encripta($this->contraseña,'encriptando')."', '$this->email', '$this->telefono', '$this->nombre', '$this->apellidos', '$this->edad')";
			$conexion->query($sql);
			Conexion::desconectarBD($conexion);
		}
		function existe(){
			$conexion = Conexion::conectarBD($this->tipo);
			$sql = "SELECT * FROM usuarios WHERE nick='$this->nick'";
			if ($result = $conexion->query($sql)) {
				if ($result->num_rows>0) {
					$fila = $result->fetch_assoc();
					//este paso tambien se puede hacer sin desencriptar y enciptando la del objeto
					if ($this->contraseña==desEncripta($fila['contraseña'],"encriptando")) {
						return true;
					}else{
						return false;
					}
				}else{
					return false;
				}
			}
			$result->free();
			Conexion::desconectarBD($conexion);
		}
		function obtenerUsuario(){
			$usuario = false;
			$conexion = Conexion::conectarBD($this->tipo);
			$sql = "SELECT * FROM usuarios";
			$result = $conexion->query($sql);
			if (!$result->num_rows<1) {
				$usuario = $result->fetch_assoc();
			}
			$result->free();
			Conexion::desconectarBD($conexion);
			return $usuario;
		}
		function obtenerUsuarios(){
			$usuarios = array();
			$conexion = Conexion::conectarBD($this->tipo);
			$sql = "SELECT * FROM usuarios";
			$result = $conexion->query($sql);
			if (!$result->num_rows<1) {
				while ($fila = $result->fetch_assoc()) {
					array_push($usuarios,$fila);
				};
			}
			$result->free();
			Conexion::desconectarBD($conexion);
			return $usuarios;
		}
		function obtenerUsuariosPaginacion($inicio,$cuantos){
			$usuarios = array();
			$conexion = Conexion::conectarBD($this->tipo);
			$sql = "SELECT * FROM usuarios LIMIT $inicio,$cuantos";
			$result = $conexion->query($sql);
			if (!$result->num_rows<1) {
				while ($fila = $result->fetch_assoc()) {
					array_push($usuarios,$fila);
				};
			}
			$result->free();
			Conexion::desconectarBD($conexion);
			return $usuarios;
		}
		function login(){
			$conexion = Conexion::conectarBD($this->tipo);
			$sql = "SELECT * FROM usuarios WHERE nick='$this->nick'";
			if ($result = $conexion->query($sql)) {
				if ($result->num_rows>0) {
					$fila = $result->fetch_assoc();
					$this->id = $fila['id'];
					$this->tipo = $fila['tipo'];
					$this->nombre = $fila['nombre'];
					$this->apellidos = $fila['apellidos'];
					$this->edad = $fila['edad'];
					$this->email = $fila['email'];
					$this->telefono = $fila['telefono'];
				}
			}
			$result->free();
			Conexion::desconectarBD($conexion);
		}
		function recuperarDatos(){
			$conexion = Conexion::conectarBD($this->tipo);
			$sql = "SELECT * FROM usuarios WHERE id='$this->id'";
			if ($result = $conexion->query($sql)) {
				if ($result->num_rows>0) {
					$fila = $result->fetch_assoc();
					$this->id = $fila['id'];
					$this->tipo = $fila['tipo'];
					$this->nombre = $fila['nombre'];
					$this->apellidos = $fila['apellidos'];
					$this->edad = $fila['edad'];
					$this->email = $fila['email'];
					$this->telefono = $fila['telefono'];
					$this->nick = $fila['nick'];
				}
			}
			$result->free();
			Conexion::desconectarBD($conexion);
		}
		function modificarUsuario(){
			$conexion = Conexion::conectarBD($this->tipo);
			$sql = "SELECT * FROM usuarios WHERE email='$this->email' OR nick='$this->nick'";
			if ($result = $conexion->query($sql)) {
				if ($result->num_rows<1) {
					$this->modificarDatos();
					return true;
				}else{
					$fila = $result->fetch_assoc();
					if ($fila['id']==$this->id) {//si la fila tiene mi id entonces actualizo igualmente
						$this->modificarDatos();
						return true;
					}else{
						return false;
					}
				}
			}
			$result->free();
			Conexion::desconectarBD($conexion);
		}
		function modificarDatos(){
			$conexion = Conexion::conectarBD($this->tipo);
			if (empty($this->contraseña)) {
				$sql = "UPDATE usuarios SET tipo='$this->tipo', nick='$this->nick', email='$this->email', telefono='$this->telefono', nombre='$this->nombre', apellidos='$this->apellidos', edad='$this->edad' WHERE id='$this->id'";
			}else{
				$sql = "UPDATE usuarios SET tipo='$this->tipo', nick='$this->nick',  contraseña='".encripta($this->contraseña,"encriptando")."', email='$this->email', telefono='$this->telefono', nombre='$this->nombre', apellidos='$this->apellidos', edad='$this->edad' WHERE id='$this->id'";
			}
			$conexion->query($sql);
			Conexion::desconectarBD($conexion);
		}
		function eliminarUsuario(){
			$conexion = Conexion::conectarBD($this->tipo);
			if ($this->id!="") {
				$sql = "DELETE FROM usuarios WHERE id='$this->id'";
			}else{
				$sql = "DELETE FROM usuarios WHERE id='".$_SESSION['id']."'";
			}
			$conexion->query($sql);
			Conexion::desconectarBD($conexion);
		}
	}
?>