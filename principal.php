<?php
include("./conexion.inc.php");//esta incluyendo el archivo conexion 
$link = conectar(); //conecta a la base de datos

if(isset($_POST['CONSULTAR'])){//si se da click en consultar se imprime todo lo que esta en la base de datos
    include("./consultar.php");
    imprimir($link);
}
if(isset($_POST['ENVIARINFORMACIÓN'])){//Si es para agregar un nuevo empleado se hace lo siguiente
    //funciones 
    function calculoSaludyPension($v1){//Funcion para calcular pension 
        $suma =0;
        $suma = $GLOBALS['sueldo']+ $v1[0]+$GLOBALS['turnosE']; 
        $porcentaje = $suma*0.04;
        return $porcentaje; 
    }

    function fechaTermino($cuotas){
        $fechaActual = date('Y-m-d');
        $mes = date("m", strtotime($fechaActual))+$cuotas;  
        $nuevaFecha = date("Y", strtotime($fechaActual))."-".$mes."-".date("d", strtotime($fechaActual));
        $nuevaFecha = date("M", strtotime($nuevaFecha))." ". date("Y", strtotime($fechaActual));
        return $nuevaFecha;
    }

    function fondoSolidaridad(){
        if($GLOBALS['sueldo']>3124968){
            return ($GLOBALS['sueldo']*0.01); 
        }else{
            return 0; 
        }
    }

    function formulaSuel ($dias,$sueldo){//formula tipica 
        return (($sueldo/30)*$dias); 
    }
    function auxilioTransporte($dias,$salario){//auxilio de transporte 
        if($salario>(908526*2)){
            return 0;
        }else{
            return ((102854/30)*$dias); 
        }
        
    }
    function recargoNocturno($sueldo,$cantidad){//caltulo del reacargo nocturno 
        $horaOrdinaria = ($sueldo/240); 
        $recargo = $horaOrdinaria*0.35;
        return (($horaOrdinaria+$recargo)*$cantidad);
    }
    function recargoDominical($sueldo,$cantidad){//calculo de recargo dominical
        $horaOrdinaria = ($sueldo/240); 
        $recargo = $horaOrdinaria*0.75;
        return (($horaOrdinaria+$recargo)*$cantidad);
    }

    function auxilioPrestacional($aux,$dias){//axulio de alimentación no prestacional 
        if($aux == 'si'){
            return ((150000/30)*$dias);
        }else{
            return 0; 
        }
        
    }

    function IncapacidadEPS($d_incapacidad, $sueldo, $dias){//calculo del valor que paga la EPS
        if((formulaSuel($d_incapacidad, $sueldo)*(0.6667)) < ((828116/30)*$dias)){//pago de la EPS
            return formulaSuel($d_incapacidad, 828116);
        }else{
            return (formulaSuel($d_incapacidad, $sueldo)*0.6667);
        }
    }

    function vacaciones($vacaciones, $sueldo, $dv){//DETERMINAR QUE TIPO DE VACACIONES SE TOMO 
        $v1=array(0,0); 
        if($vacaciones =='vacacionesDisfrutadas'){
            $v1[0]=formulaSuel($dv,$sueldo);
            $v1[1]=0; 
        }else if($vacaciones =='vacacionesCompensadas'){
            $v1[1]=formulaSuel($dv,$sueldo);
            $v1[0]=0; 
        }
        return $v1;

        
    }
    function sumar($diasSuel,$v1,$v2,$aux, $incapacidad, $eps, $arl, $turnosE,$recargoNocturno, $dominicales, $auxilioNo){
        $total = $diasSuel+$v1+$v2+$aux+$incapacidad+$eps+$arl+$turnosE+$recargoNocturno+ $dominicales+ $auxilioNo;
        return $total; 
    }
    //DATOS EMPLEADOS
    $nom = $_REQUEST['nom'];
    $cc = $_REQUEST['cc'];
    $cargo = $_REQUEST['cargo'];
    $id = $_REQUEST['id'];
    $sueldo = $_REQUEST['sueldo'];

    //datos devengados tomados por el formulario

    $dias = $_REQUEST['dias'];
    $vacaciones = $_REQUEST['vac'];
    $dv = $_REQUEST['diasV'];
    $d_incapacidad = $_REQUEST['incap'];
    $turnosE = $_REQUEST['extra'];
    $nocturno = $_REQUEST['noctur'];
    $dominicales = $_REQUEST['domin'];
    $alimentacion = $_REQUEST['alimentacion'];

    //llamar funciones para completar 
    $diasSuel = round(formulaSuel($dias,$sueldo));//Salario de acuerdo a los días trabajados
    $v1=vacaciones($vacaciones, $sueldo, $dv); //consultar si son vacaciones compensadas o disfrutadas
    $aux =round( auxilioTransporte($dias,$sueldo));//valor del auxilio del transporte 
    $incapacidad = round(formulaSuel($d_incapacidad, $sueldo)); //valor de la incapacidad de acuerdo a los días 
    $eps=round(IncapacidadEPS($d_incapacidad, $sueldo, $dias)); //valor que paga la eps por la incapacidad 
    $arl=round(formulaSuel($d_incapacidad, $sueldo)); //valor que paga ARL por incapacidad
    $turnosE=round(formulaSuel($turnosE, $diasSuel));//valor por los turnos extras realizados 
    $recargoNocturno = round(recargoNocturno($sueldo,$nocturno)); //valor por horas nocturnas 
    $dominicales =round(recargoDominical($sueldo,$dominicales));//recargo por trabajar dominicales 
    $auxilioNo = round(auxilioPrestacional($alimentacion,$dias));//auxilio de alimentación no prestacional
    $total =sumar($diasSuel,$v1[0],$v1[1],$aux, $incapacidad, $eps, $arl, $turnosE,$recargoNocturno, $dominicales, $auxilioNo); 



    //DATOS DEDUCCIONES 
    $anticipo = $_REQUEST['anti'];
    $valor_desembolso = $_REQUEST['des']; //este es el monto del desembolso
    $numero_cuotas = $_REQUEST['cuotas'];
    $fechaAnticipo = $_REQUEST['fecha'];
    $cuotaActual = $_REQUEST['actual'];  


    //datos calculados de la tabla deducciones va
    $salud  = calculoSaludYPension($v1); 
    $pension = calculoSaludyPension($v1); 
    $fondo = fondoSolidaridad(); 
    $pagoVacaciones = $v1[0]+$v1[1];
    $cuotas_descontar = ($numero_cuotas-$cuotaActual); 
    $termino = fechaTermino($cuotas_descontar);
    if($numero_cuotas!=0){
        $valorCuota = ($valor_desembolso/$numero_cuotas); 
    }else{
        $valorCuota=0;
    }
    
    $saldo = ($valor_desembolso-($valorCuota*$cuotaActual));
    $totalDedu = $salud + $pension + $fondo +$anticipo + $pagoVacaciones +$valorCuota; 

    //total nomina 
    $totalNomina = $total-$totalDedu;

    //--------------------------------------------------------------------------------
    //INSERTAR DATOS EN LA BASE DE DATOS

    //INSERTAR DATOS EMPLEADOS
    $sql = "insert into empleado values('$nom','$cc','$cargo',$id,$sueldo);";//Sentencia SQL
    $result=mysqli_query($link,$sql) //Con esta función ejecutamos la consulta
    or die ("ERROR EN LA CONSULTA $sql ".mysqli_error($link)); 
    //INSERTAR DATOS DEVENGADOS
    $sql="insert into devengados values($dias, $diasSuel,$v1[0],$v1[1],$aux, $incapacidad, $eps, $arl, $turnosE,$recargoNocturno, $dominicales, $auxilioNo, $total, $id)"; 
    $result=mysqli_query($link,$sql) //Con esta función ejecutamos la consulta
    or die ("ERROR EN LA CONSULTA $sql ".mysqli_error($link)); 
    //insertar datos DEDUCCIONES
    
    $sql = "insert into deduciones values($salud,$pension,$fondo,$anticipo, $pagoVacaciones, $valor_desembolso, $numero_cuotas, 
    '$fechaAnticipo', $cuotaActual, $cuotas_descontar, '$termino', $valorCuota, $saldo, $totalDedu, $id)";
    $result = mysqli_query($link,$sql) or die ("ERROR AL INSERTAR DATOS EN DEDUCCIONES $sql ".mysqli_error($link)); //Con esta función ejecutamos la consulta

}
include("./consultar.php");//Apenas termine de agregar el empleado se muestran los datos.
    imprimir($link); 

?>


