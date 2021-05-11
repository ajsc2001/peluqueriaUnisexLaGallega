<?php
include "../recursos/fpdf-1.83/fpdf.php";
require "conexion.php";
include "../class/cita.php";
include "../class/usuario.php";
include "../class/servicio.php";
$cita = new Cita("Cliente",$_GET['id']);
if (!$cita->obtenerCita()) {
    header("Location: ../index.php?p=reservas");
}else{
    $cita = $cita->obtenerCita();
    $usuario = new Usuario($cita['id_usuario'],"Cliente");
    $usuario = $usuario->obtenerUsuario();
    $nombreServicios = explode(", ",$cita['motivos']);
    $nombreServicios[count($nombreServicios) - 1] = substr($nombreServicios[count($nombreServicios) - 1],0,-1);
    $servicios = new Servicio("Cliente");
    $servicios = $servicios->obtenerServiciosPorNombre($nombreServicios);
    //Creación de PDF
    $pdf = new FPDF($orientation='P',$unit='mm');
    $pdf->AddPage();
    $pdf->SetFont('Arial','B',20);    
    $textypos = 5;
    $pdf->setY(12);
    $pdf->setX(10);
    //Datos de la empresa
    $pdf->Cell(5,$textypos,"DATOS DE LA CITA:");
    $pdf->SetFont('Arial','B',10);    
    $pdf->setY(30);$pdf->setX(10);
    $pdf->Cell(5,$textypos,"DE:");
    $pdf->SetFont('Arial','',10);    
    $pdf->setY(35);$pdf->setX(10);
    $pdf->Cell(5,$textypos,iconv("utf-8", "ISO-8859-2","Peluquería Unisex 'La Gallega'"));
    $pdf->setY(40);$pdf->setX(10);
    $pdf->Cell(5,$textypos,iconv("utf-8", "ISO-8859-2","Calle Santiago el Mayor, 33"));
    $pdf->setY(45);$pdf->setX(10);
    $pdf->Cell(5,$textypos,iconv("utf-8", "ISO-8859-2","Albatera (Alicante)"));
    $pdf->Cell(5,$textypos,"");
    $pdf->setY(50);$pdf->setX(10);
    $pdf->Cell(5,$textypos,iconv("utf-8", "ISO-8859-2","653235994 - 965488166"));
    $pdf->setY(55);$pdf->setX(10);
    $pdf->Cell(5,$textypos,iconv("utf-8", "ISO-8859-2","lagallega_ccg@hotmail.com"));
    //Datos del cliente
    $pdf->SetFont('Arial','B',10);    
    $pdf->setY(30);$pdf->setX(75);
    $pdf->Cell(5,$textypos,"PARA:");
    $pdf->SetFont('Arial','',10);    
    $pdf->setY(35);$pdf->setX(75);
    $pdf->Cell(5,$textypos,iconv("utf-8", "ISO-8859-2","Usuario: ".$usuario['nick']));
    $pdf->setY(40);$pdf->setX(75);
    $pdf->Cell(5,$textypos,iconv("utf-8", "ISO-8859-2",$usuario['nombre']));
    $pdf->setY(45);$pdf->setX(75);
    $pdf->Cell(5,$textypos,iconv("utf-8", "ISO-8859-2",$usuario['apellidos']));
    $pdf->setY(50);$pdf->setX(75);
    $pdf->Cell(5,$textypos,iconv("utf-8", "ISO-8859-2",$usuario['telefono']));
    $pdf->setY(55);$pdf->setX(75);
    $pdf->Cell(5,$textypos,iconv("utf-8", "ISO-8859-2",$usuario['email']));
    //Datos cita
    $pdf->SetFont('Arial','B',10);    
    $pdf->setY(30);$pdf->setX(150);
    $pdf->Cell(5,$textypos,iconv("utf-8", "ISO-8859-2","CITA N".$cita['id'].":"));
    $pdf->SetFont('Arial','',10);    
    $pdf->setY(35);$pdf->setX(150);
    $pdf->Cell(5,$textypos,iconv("utf-8", "ISO-8859-2","Fecha: ".substr($cita['fecha'],0,-3)));
    $pdf->setY(40);$pdf->setX(150);
    $pdf->Cell(5,$textypos,iconv("utf-8", "ISO-8859-2","Duración: ".substr($cita['tiempo'],0,-3)));
    $pdf->setY(45);$pdf->setX(150);
    $pdf->Cell(5,$textypos,"");
    $pdf->setY(50);$pdf->setX(150);
    $pdf->Cell(5,$textypos,"");
    //Tabla servicios prestados
    $pdf->SetFont('Arial','B',10); 
    $pdf->setY(70);$pdf->setX(10);
    $pdf->Cell(5,$textypos,"SERVICIOS PRESTADOS:");
    $pdf->SetFont('Arial','',10);   
    $pdf->setY(75);$pdf->setX(135);
    $pdf->Ln();
    //Array de Cabecera
    $header = array("Cod.", "Nombre","Tiempo necesario");
    // Column widths
    $w = array(20, 40, 40);
    //Cabecera
    $pdf->SetFont('Arial','U',10); 
    for($i=0;$i<count($header);$i++)
        $pdf->Cell($w[$i],7,$header[$i],1,0,'C');
    $pdf->Ln();
    //Datos servicios
    $pdf->SetFont('Arial','',10); 
    foreach($servicios as $servicio){
        $pdf->Cell($w[0],6,$servicio['id'],1,0,'C');
        $pdf->Cell($w[1],6,iconv("utf-8", "ISO-8859-2",$servicio['nombre']),1,0,'C');
        $pdf->Cell($w[2],6,$servicio['tiempo'],1,0,'C');
        $pdf->Ln();
    }
    $pdf->SetFont('Arial','B',10);    
    $pdf->setY(110);
    $pdf->setX(10);
    $pdf->Cell(5,$textypos,"TERMINOS Y CONDICIONES");
    $pdf->SetFont('Arial','',10);    
    $pdf->setY(120);
    $pdf->setX(10);
    $pdf->Cell(5,$textypos,"El cliente se compromete a asistir a dicha cita y a aportar el importe total de la cita.");
    $pdf->setY(125);
    $pdf->setX(10);
    $pdf->Cell(5,$textypos,iconv("utf-8", "ISO-8859-2","En caso de no poder asistir se ruega avisar con antelación."));
    $pdf->setY(140);
    $pdf->setX(10);
    $pdf->Cell(5,$textypos,"Firmado:");
    $pdf->Image('../img/logo.png',10,150,-300);
    $pdf->output();
}