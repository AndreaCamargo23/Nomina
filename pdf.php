<?php
require('pdf/fpdf.php');
include("./conexion.inc.php");//esta incluyendo el archivo conexion 
$link = conectar(); 

//Cabecera de página

$pdf = new FPDF('L', 'mm', 'A3');
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);
$pdf->Cell(60,10, '',0,1,'C');
$pdf->Cell(33, 10); 
$pdf->Cell(60,10, 'Nomina Empleados',0,1,'C');
$pdf->Ln(20); 
$pdf->SetFillColor(141,156,161);//Fondo verde de celda
$pdf->SetTextColor(3, 3, 3); //Letra color blanco
$pdf->SetFont('Arial','B',9);
//extraer los datos 
$sql = "select e.nombre,e.cent_costo,e.Cargo,e.id, e.sueldo,(d.total-de.total_deduccion) as 'Total Nomina' from devengados d INNER JOIN deduciones de on (d.id_empleado=de.id_empleado)
        INNER JOIN empleado e on(e.id=d.id_empleado);";
$res= mysqli_query($link,$sql) 
        or die ("ERROR EN LA CONSULTA $sql ".mysqli_error($link));
//Extraer valor de la nomina 
$sql="select sum(sueldo) as 'Total Sueldo',sum(d.total-de.total_deduccion) as 'Total Nomina' from devengados d INNER JOIN deduciones de on (d.id_empleado=de.id_empleado)
        INNER JOIN empleado e on(e.id=d.id_empleado);";
$suma= mysqli_query($link,$sql) 
        or die ("ERROR EN LA CONSULTA $sql ".mysqli_error($link)); 
//Creacion de la tabla  
$pdf->TablaBasica($res,$suma);
$pdf->Ln(10); 
$pdf->SetFillColor(141,156,0);//Fondo verde de celda
$pdf->SetTextColor(3, 3, 3); //Letra color blanco
$pdf->SetFont('Arial','B',10);
//datos devengados 
$sql = "select * from devengados"; 
$res= mysqli_query($link,$sql) 
        or die ("ERROR EN LA CONSULTA $sql ".mysqli_error($link));
$sql="select sum(salario_dias), sum(v_disfrutdas), sum(v_compensadas), sum(auxilio), sum(incapacidad), sum(eps), sum(arl), sum(extra_turno),
sum(nocturno), sum(dominicales), sum(aux_alimentacion), sum(total) from devengados;";
$suma= mysqli_query($link,$sql) 
      or die ("ERROR EN LA CONSULTA $sql ".mysqli_error($link));
$pdf->devengados($res,$suma);

$pdf->SetFillColor(168,156,0);//Fondo verde de celda
$pdf->SetTextColor(3, 3, 3); //Letra color blanco
$pdf->SetFont('Arial','B',8);
$pdf->Ln(10); 

//datos deducciones
$sql = "select * from deduciones"; 
$res= mysqli_query($link,$sql) 
        or die ("ERROR EN LA CONSULTA $sql ".mysqli_error($link));
$sql="select sum(salud), sum(pension), sum(fondo), sum(anticipo),
         sum(pago_v), sum(desembolso), sum(valor_cuota), 
        sum(saldo_prestamo),sum(total_deduccion) from deduciones;";
$suma= mysqli_query($link,$sql) 
        or die ("ERROR EN LA CONSULTA $sql ".mysqli_error($link));
$pdf->deducciones($res,$suma);

$pdf->Output('Desprendible.pdf','I');
?>