<?php
require "lib/codificacion.php";
	Class Usuario{
		private $id;
		private $tipo;
		private $nombre;
		private $apellidos;
		private $edad;
		private $email;
		private $telefono;
		private $nick;
		private $contraseña;
		function __construct($id="",$tipo="",$nombre="",$apellidos="",$edad="",$email="",$telefono="",$nick="",$contraseña=""){
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
		function crearUsuario(){
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
			$result->free();//no se si hay que ponerlo
			Conexion::desconectarBD($conexion);
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
		function recuperarDatos(){
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
	}
?>