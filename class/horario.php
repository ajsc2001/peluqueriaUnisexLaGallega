<?php
Class Horario{
    private $tipo_usr;
	private $lunes;
	private $martes;
    private $miercoles;
    private $jueves;
    private $viernes;
    private $sabado;
    private $domingo;
    //poner usuario de visitante como base
    function __construct($tipo_usr="root",$lunes=array(),$martes=array(),$miercoles=array(),$jueves=array(),$viernes=array(),$sabado=array(),$domingo=array()){
		$this->tipo_usr = $tipo_usr;
		$this->lunes = $lunes;
		$this->martes = $martes;
		$this->miercoles = $miercoles;
		$this->jueves = $jueves;
		$this->viernes = $viernes;
		$this->sabado = $sabado;
		$this->domingo = $domingo;
	}
    function get_lunes(){
        return $this->lunes;
    }
    function get_martes(){
        return $this->martes;
    }
    function get_miercoles(){
        return $this->miercoles;
    }
    function get_jueves(){
        return $this->jueves;
    }
    function get_viernes(){
        return $this->viernes;
    }
    function get_sabado(){
        return $this->sabado;
    }
    function get_domingo(){
        return $this->domingo;
    }
    function obtenerDias(){
        $creado = false;
        $conexion = Conexion::conectarBD($this->tipo_usr);
        $sql = "SELECT * FROM horario";
        if ($result = $conexion->query($sql)) {
            if ($result->num_rows<1) {
                $this->crearDias();
                $creado = true;
            }
        }
        while ($fila = $result->fetch_assoc()) {
            //los añado al objeto
            switch ($fila['dia']) {
                case "Lunes":
                    $this->lunes = $fila;
                    break;
                case "Martes":
                    $this->martes = $fila;
                    break;
                case "Miércoles":
                    $this->miercoles = $fila;
                    break;
                case "Jueves":
                    $this->jueves = $fila;
                    break;
                case "Viernes":
                    $this->viernes = $fila;
                    break;
                case "Sábado":
                    $this->sabado = $fila;
                    break;
                case "Domingo":
                    $this->domingo = $fila;
                    break;
            }
        }
        $result->free();//no se si hay que ponerlo
        Conexion::desconectarBD($conexion);
        return $creado;
    }
    function crearDias(){
        $conexion = Conexion::conectarBD($this->tipo_usr);
        $dias = array("Lunes","Martes","Miércoles","Jueves","Viernes","Sábado","Domingo");
        foreach ($dias as $key) {
            $sql = "INSERT INTO horario (dia, aperturaMañana, cierreMañana, aperturaTarde, cierreTarde, cerrado) VALUES ('$key', '00:00', '00:00', '00:00', '00:00', true)";
	        $conexion->query($sql);
        }
	    Conexion::desconectarBD($conexion);
    }
    function modificarDias(){
        $conexion = Conexion::conectarBD($this->tipo_usr);
        //modifico lunes
		$sql = "UPDATE horario SET aperturaMañana='".$this->lunes['aperturaMañana']."', cierreMañana='".$this->lunes['cierreMañana']."', aperturaTarde='".$this->lunes['aperturaTarde']."', cierreTarde='".$this->lunes['cierreTarde']."', cerrado='".$this->lunes['cerrado']."'  WHERE dia='".$this->lunes['dia']."'";
		$conexion->query($sql);
        //modifico martes
		$sql = "UPDATE horario SET aperturaMañana='".$this->martes['aperturaMañana']."', cierreMañana='".$this->martes['cierreMañana']."', aperturaTarde='".$this->martes['aperturaTarde']."', cierreTarde='".$this->martes['cierreTarde']."', cerrado='".$this->martes['cerrado']."'  WHERE dia='".$this->martes['dia']."'";
		$conexion->query($sql);
        //modifico miercoles
		$sql = "UPDATE horario SET aperturaMañana='".$this->miercoles['aperturaMañana']."', cierreMañana='".$this->miercoles['cierreMañana']."', aperturaTarde='".$this->miercoles['aperturaTarde']."', cierreTarde='".$this->miercoles['cierreTarde']."', cerrado='".$this->miercoles['cerrado']."'  WHERE dia='".$this->miercoles['dia']."'";
		$conexion->query($sql);
        //modifico jueves
		$sql = "UPDATE horario SET aperturaMañana='".$this->jueves['aperturaMañana']."', cierreMañana='".$this->jueves['cierreMañana']."', aperturaTarde='".$this->jueves['aperturaTarde']."', cierreTarde='".$this->jueves['cierreTarde']."', cerrado='".$this->jueves['cerrado']."'  WHERE dia='".$this->jueves['dia']."'";
		$conexion->query($sql);
        //modifico viernes
		$sql = "UPDATE horario SET aperturaMañana='".$this->viernes['aperturaMañana']."', cierreMañana='".$this->viernes['cierreMañana']."', aperturaTarde='".$this->viernes['aperturaTarde']."', cierreTarde='".$this->viernes['cierreTarde']."', cerrado='".$this->viernes['cerrado']."'  WHERE dia='".$this->viernes['dia']."'";
		$conexion->query($sql);
        //modifico sabado
		$sql = "UPDATE horario SET aperturaMañana='".$this->sabado['aperturaMañana']."', cierreMañana='".$this->sabado['cierreMañana']."', aperturaTarde='".$this->sabado['aperturaTarde']."', cierreTarde='".$this->sabado['cierreTarde']."', cerrado='".$this->sabado['cerrado']."'  WHERE dia='".$this->sabado['dia']."'";
		$conexion->query($sql);
        //modifico domingo
		$sql = "UPDATE horario SET aperturaMañana='".$this->domingo['aperturaMañana']."', cierreMañana='".$this->domingo['cierreMañana']."', aperturaTarde='".$this->domingo['aperturaTarde']."', cierreTarde='".$this->domingo['cierreTarde']."', cerrado='".$this->domingo['cerrado']."'  WHERE dia='".$this->domingo['dia']."'";
		$conexion->query($sql);
		Conexion::desconectarBD($conexion);
    }
    function obtenerDia($dia){//return del dia
        $conexion = Conexion::conectarBD($this->tipo);
        $sql = "SELECT * FROM horario WHERE dia='$dia'";
		$result->free();
		Conexion::desconectarBD($conexion);
    }
}
?>