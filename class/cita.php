<?php
Class Cita{
    private $tipo_usr;
	private $id;
	private $motivos;
    private $fecha;
    private $id_usuario;
    //poner usuario de visitante como base
    function __construct($tipo_usr="Cliente",$id="",$motivos="",$fecha="",$id_usuario){
		$this->tipo_usr = $tipo_usr;
		$this->id = $id;
		$this->motivos = $motivos;
		$this->fecha = $fecha;
		$this->id_usuario = $id_usuario;
	}
	function crearCita(){
        $conexion = Conexion::conectarBD($this->tipo_usr);


		
		$sql = "INSERT INTO citas (motivos, fecha, id_usuario) VALUES ('$this->motivos', '$this->fecha', '$this->id_usuario')";
	    $conexion->query($sql);
	    Conexion::desconectarBD($conexion);
    }







}
?>