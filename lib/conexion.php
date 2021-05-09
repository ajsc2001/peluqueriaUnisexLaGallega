<?php
	Class Conexion{
		public static function conectarBD($tipoUsr){
			$server = "localhost";
			//hosting
			/*$usr = "lagallega_root";
			$pass = "Ccg_28112004";
			$bd = "lagallega_peluqueria";*/
			//local
			$usr = "root";
			$pass = "";
			$bd = "peluqueria";
			$mysqli = new mysqli($server, $usr, $pass, $bd);
			if ($mysqli->connect_errno) {
				echo "Error: Fallo al conectarse a MySQL debido a: \n";
				echo "Errno: " . $mysqli->connect_errno . "\n";
				echo "Error: " . $mysqli->connect_error . "\n";
				exit;
			}
			$mysqli->set_charset("utf8");
			return $mysqli;
		}
		public static function desconectarBD($mysqli){
			$mysqli->close();
		}
	}
?>