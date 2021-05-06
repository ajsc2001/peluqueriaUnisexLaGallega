<?php
Class Servicio{
	private $tipo_usr;
    private $id;
	private $nombre;
	private $tiempo;
    //poner usuario de visitante como base
    function __construct($tipo_usr="Cliente",$id="",$nombre="",$tiempo=""){
		$this->tipo_usr = $tipo_usr;
		$this->id = $id;
		$this->nombre = $nombre;
		$this->tiempo = $tiempo;
	}
    function obtenerServicios(){
        $servicios = array();
        $conexion = Conexion::conectarBD($this->tipo_usr);
        $sql = "SELECT * FROM servicios";
        $result = $conexion->query($sql);
        if (!$result->num_rows<1) {
            while ($fila = $result->fetch_assoc()) {
                //los añado al array de objetos
                array_push($servicios,$fila);
            };
        }
        $result->free();//no se si hay que ponerlo
        Conexion::desconectarBD($conexion);
        return $servicios;
    }
    function obtenerServiciosPaginacion($inicio,$cuantos){
        $servicios = array();
        $conexion = Conexion::conectarBD($this->tipo_usr);
        $sql = "SELECT * FROM servicios LIMIT $inicio,$cuantos";
        $result = $conexion->query($sql);
        if (!$result->num_rows<1) {
            while ($fila = $result->fetch_assoc()) {
                //los añado al objeto
                array_push($servicios,$fila);
            };
        }
        $result->free();//no se si hay que ponerlo
        Conexion::desconectarBD($conexion);
        return $servicios;
    }
    function modificarServicio(){
        $conexion = Conexion::conectarBD($this->tipo_usr);
        $sql = "SELECT * FROM servicios WHERE nombre='$this->nombre'";
        if ($result = $conexion->query($sql)) {
            if ($result->num_rows<1) {
                $this->modificarDatos();
                return true;
            }else{
                $fila = $result->fetch_assoc();
                //si la fila tiene mi id entonces actualizo igualmente
				if ($fila['id']==$this->id) {
					$this->modificarDatos();
					return true;
				}else{
					return false;
				}
            }
        }
        $result->free();//no se si hay que ponerlo
        Conexion::desconectarBD($conexion);
    }
    function modificarDatos(){
        $conexion = Conexion::conectarBD($this->tipo_usr);
		$sql = "UPDATE servicios SET nombre='$this->nombre', tiempo='$this->tiempo' WHERE id='$this->id'";
		$conexion->query($sql);
		Conexion::desconectarBD($conexion);
    }
    function nuevoServicio(){
        $conexion = Conexion::conectarBD($this->tipo_usr);
        $sql = "SELECT * FROM servicios WHERE nombre='$this->nombre'";
        if ($result = $conexion->query($sql)) {
            if ($result->num_rows<1) {
                $this->añadirServicio();
                return true;
            }else{
                return false;
            }
        }
        $result->free();//no se si hay que ponerlo
        Conexion::desconectarBD($conexion);
    }
    function añadirServicio(){
        $conexion = Conexion::conectarBD($this->tipo_usr);
        $sql = "INSERT INTO servicios (nombre, tiempo) VALUES ('$this->nombre', '$this->tiempo')";
	    $conexion->query($sql);
	    Conexion::desconectarBD($conexion);
    }
    function eliminarServicio(){
        $conexion = Conexion::conectarBD($this->tipo);
        $sql = "DELETE FROM servicios WHERE id='$this->id'";
        $conexion->query($sql);
        Conexion::desconectarBD($conexion);
    }
}
?>