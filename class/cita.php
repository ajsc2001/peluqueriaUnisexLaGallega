<?php
Class Cita{
    private $tipo_usr;
	private $id;
	private $motivos;
    private $fecha;
    private $tiempo;
    private $id_usuario;
    function __construct($tipo_usr="Cliente",$id="",$motivos="",$fecha="",$tiempo="",$id_usuario=""){
		$this->tipo_usr = $tipo_usr;
		$this->id = $id;
		$this->motivos = $motivos;
		$this->fecha = $fecha;
		$this->tiempo = $tiempo;
		$this->id_usuario = $id_usuario;
	}
	function crearCita(){
		$conexion = Conexion::conectarBD($this->tipo_usr);
		$sql = "SELECT * FROM citas WHERE fecha='$this->fecha'";
		if ($result = $conexion->query($sql)) {
			if ($result->num_rows<1) {
				$this->añadirCita();
				return true;
			}else{
				return false;
			}
		}
		$result->free();
		Conexion::desconectarBD($conexion);
	}
	function añadirCita(){
		$conexion = Conexion::conectarBD($this->tipo_usr);
		$sql = "INSERT INTO citas (motivos, fecha, tiempo, id_usuario) VALUES ('$this->motivos', '$this->fecha', '$this->tiempo', '$this->id_usuario')";
	    $conexion->query($sql);
	    Conexion::desconectarBD($conexion);
    }
	function obtenerCita(){
        $cita = false;
        $conexion = Conexion::conectarBD($this->tipo_usr);
        $sql = "SELECT * FROM citas WHERE id='$this->id'";
        $result = $conexion->query($sql);
        if (!$result->num_rows<1) {
            $cita = $result->fetch_assoc();
        }
        $result->free();
        Conexion::desconectarBD($conexion);
        return $cita;
    }
	function obtenerCitas(){
        $citas = array();
        $conexion = Conexion::conectarBD($this->tipo_usr);
        $sql = "SELECT * FROM citas";
        $result = $conexion->query($sql);
        if (!$result->num_rows<1) {
            while ($fila = $result->fetch_assoc()) {
                array_push($citas,$fila);
            };
        }
        $result->free();
        Conexion::desconectarBD($conexion);
        return $citas;
    }
	function obtenerCitasPorFecha(){
        $citas = array();
        $conexion = Conexion::conectarBD($this->tipo_usr);
        $sql = "SELECT * FROM citas WHERE fecha LIKE '".substr($this->fecha,0,10)."%' ORDER BY fecha";
        $result = $conexion->query($sql);
        if (!$result->num_rows<1) {
            while ($fila = $result->fetch_assoc()) {
                array_push($citas,$fila);
            };
        }
        $result->free();
        Conexion::desconectarBD($conexion);
        return $citas;
    }
    function obtenerCitasPaginacion($inicio,$cuantos){
        $citas = array();
        $conexion = Conexion::conectarBD($this->tipo_usr);
        if ($this->tipo_usr=="Cliente") {
            $sql = "SELECT * FROM citas WHERE id_usuario='".$_SESSION['id']."' LIMIT $inicio,$cuantos";
        }else{
            $sql = "SELECT * FROM citas LIMIT $inicio,$cuantos";
        }
        $result = $conexion->query($sql);
        if (!$result->num_rows<1) {
            while ($fila = $result->fetch_assoc()) {
                array_push($citas,$fila);
            };
        }
        $result->free();
        Conexion::desconectarBD($conexion);
        return $citas;
    }
    function eliminarCita(){
        $conexion = Conexion::conectarBD($this->tipo);
        $sql = "DELETE FROM citas WHERE id='$this->id'";
        $conexion->query($sql);
        Conexion::desconectarBD($conexion);
    }
}
?>