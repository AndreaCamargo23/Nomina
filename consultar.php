<?php
function imprimir($link){
  
    
?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
<div class="jumbotron bg-info" ><!--Jumbotron -->
        <h1>NOMINA EMPLEADOS</h1>
</div>    
    <form><br> 
            <div class='container-fluid form-row' style="margin-left: 50px;">
                <div class='form-group col-sm-9'>
                    <table border='0' align='center' class='table table-secondary table-striped table-responsive'>
                        <thead align='center'><th colspan=6 >Información General</th></thead>
                        <thead><tr>
                        <th>Nombre</th>
                        <th>Centro de costos</th>
                        <th>Cargo</th>
                        <th>No Identificación</th>
                        <th>Sueldo</th>
                        <th>Total Nomina</th>
                        </tr> </thead>

    <?php 
                
        $sql = "select e.nombre,e.cent_costo,e.Cargo,e.id, e.sueldo,(d.total-de.total_deduccion) as 'Total Nomina' from devengados d INNER JOIN deduciones de on (d.id_empleado=de.id_empleado)
        INNER JOIN empleado e on(e.id=d.id_empleado);"; 
        $res= mysqli_query($link,$sql) 
        or die ("ERROR EN LA CONSULTA $sql ".mysqli_error($link)); 
        while($row=mysqli_fetch_array($res)){//se genera un vector o un array de cada registro 
            //cuando ya no hayan datos se va a generar el ciclo
            print "<tr><td>".$row['nombre']."</td><td>".$row['cent_costo']."</td><td>".$row['Cargo']."</td><td>".$row['id']."</td><td>$".number_format($row['sueldo'])."</td><td>$".number_format($row['Total Nomina'])."</td></tr>"; 
        }
        $sql="select sum(sueldo) as 'Total Sueldo',sum(d.total-de.total_deduccion) as 'Total Nomina' from devengados d INNER JOIN deduciones de on (d.id_empleado=de.id_empleado)
        INNER JOIN empleado e on(e.id=d.id_empleado);";
        $res= mysqli_query($link,$sql) 
        or die ("ERROR EN LA CONSULTA $sql ".mysqli_error($link));
        $row=mysqli_fetch_array($res);
        print"<tr><td></td><td></td><td></td><td>Total</td><td>$".number_format($row['Total Sueldo'])."</td><td>$".number_format($row['Total Nomina'])."</td></tr>";
    ?>
                    </table>
                </div>
            </div>

            <div class='container-fluid form-row' style="margin-left: 50px;">
                <div class='form-group col-sm-10'>
                    <table border='0' align='center' class='table table-primary table-striped table-responsive'>
                    <thead align='center'><th colspan=14>Devengados</th></thead>
                    <thead><tr>
                        <th>ID</th>
                        <th>Días laborados</th>
                        <th>Salario según días</th>
                        <th>Vacaciones disfrutadas</th>
                        <th>Vacaciones Compensadas</th>
                        <th>Auxilio de transporte</th>
                        <th>Auxilio Monetario por incapacidad</th>
                        <th>Pago incapacidad EPS</th>
                        <th>Pago incapacidad ARL</th>
                        <th>Extra turno</th>
                        <th>Recargo Nocturno</th>
                        <th>H. Dominicales</th>
                        <th>Aux. Alimentación no prestacional</th>
                        <th>TOTAL</th>
                    </tr> </thead>

    <?php 
        $sql = "select * from devengados"; 
        $res= mysqli_query($link,$sql) 
        or die ("ERROR EN LA CONSULTA $sql ".mysqli_error($link)); 
        while($row=mysqli_fetch_array($res)){//se genera un vector o un array de cada registro 
            //cuando ya no hayan datos se va a generar el ciclo
            print "<tr><td>".$row['id_empleado']."</td><td>".$row['dias']."</td><td>".number_format($row['salario_dias'])."</td><td>".number_format($row['v_disfrutdas'])."</td>
            <td>".number_format($row['v_compensadas'])."</td><td>".number_format($row['auxilio'])."</td><td>".number_format($row['incapacidad'])."</td>
            <td>".number_format($row['eps'])."</td><td>".number_format($row['arl'])."</td><td>".number_format($row['extra_turno'])."</td>
            <td>".number_format($row['nocturno'])."</td><td>".number_format($row['dominicales'])."</td><td>".number_format($row['aux_alimentacion'])."</td>
            <td>".number_format($row['total'])."</td></tr>"; 
        }
        $sql="select sum(salario_dias), sum(v_disfrutdas), sum(v_compensadas), sum(auxilio), sum(incapacidad), sum(eps), sum(arl), sum(extra_turno),
        sum(nocturno), sum(dominicales), sum(aux_alimentacion), sum(total) from devengados;";
        $res= mysqli_query($link,$sql) 
        or die ("ERROR EN LA CONSULTA $sql ".mysqli_error($link));
        $row=mysqli_fetch_array($res);
        print"<tr><td></td><td></td><td>$".number_format($row['sum(salario_dias)'])."</td><td>$".number_format($row['sum(v_disfrutdas)'])."</td>
        <td>$".number_format($row['sum(v_compensadas)'])."</td><td>$".number_format($row['sum(auxilio)'])."</td>
        <td>$".number_format($row['sum(incapacidad)'])."</td><td>$".number_format($row['sum(eps)'])."</td>
        <td>$".number_format($row['sum(arl)'])."</td><td>$".number_format($row['sum(extra_turno)'])."</td>
        <td>$".number_format($row['sum(nocturno)'])."</td><td>$".number_format($row['sum(dominicales)'])."</td>
        <td>$".number_format($row['sum(aux_alimentacion)'])."</td><td>$".number_format($row['sum(total)'])."</td></tr>";    
    ?>
                    </table>
                </div>
            </div>

            <div class='container-fluid form-row' style="margin-left: 50px;">
                <div class='form-group col-sm-11' align='center'>
                    <table border='0' align='center' class='table table-success table-striped table-responsive'>
                    <thead align='center'><th colspan=15>Deduccciones</th></thead>    
                    <thead><tr>
                            <th>ID</th>
                            <th>Salud</th>
                            <th>Pension</th>
                            <th>Fondo de solidaridad pensional</th>
                            <th>Anticipos nomina</th>
                            <th>Pago vacaciones</th>
                            <th>Monto del desembolso</th>
                            <th>No de cuotas a descontar</th>
                            <th>Fecha del desembolso</th>
                            <th>No cuota pagada</th>
                            <th>Cuotas por descontar</th>
                            <th>Nomina en que termina el prestamo</th>
                            <th>Valor Cuota</th>
                            <th>Saldo Prestamo</th>
                            <th>TOTAL</th>
                        </tr> </thead>
                        <?php
                        $sql = "select * from deduciones"; 
                        $res= mysqli_query($link,$sql) 
                        or die ("ERROR EN LA CONSULTA $sql ".mysqli_error($link)); 
                        while($row=mysqli_fetch_array($res)){//se genera un vector o un array de cada registro 
                            //cuando ya no hayan datos se va a generar el ciclo
                            print "<tr><td>".$row['id_empleado']."</td><td>".number_format($row['salud'])."</td><td>".number_format($row['pension'])."</td><td>".number_format($row['fondo'])."</td>
                            <td>".number_format($row['anticipo'])."</td><td>".number_format($row['pago_v'])."</td><td>".number_format($row['desembolso'])."</td>
                            <td>".$row['no_coutas']."</td><td>".$row['fecha_desembolso']."</td><td>".$row['no_cuota_pagada']."</td>
                            <td>".number_format($row['cuotas_descontar'])."</td><td>".$row['mes_pagado_prestamo']."</td><td>".number_format($row['valor_cuota'])."</td>
                            <td>".number_format($row['saldo_prestamo'])."</td><td>".number_format($row['total_deduccion'])."</td></tr>"; 
                        }
                        $sql="select sum(salud), sum(pension), sum(fondo), sum(anticipo), sum(pago_v), sum(desembolso), sum(valor_cuota), 
                        sum(saldo_prestamo),
                        sum(total_deduccion) from deduciones;";
                        $res= mysqli_query($link,$sql) 
                        or die ("ERROR EN LA CONSULTA $sql ".mysqli_error($link));
                        $row=mysqli_fetch_array($res);
                        print"<tr><td></td><td>$".number_format($row['sum(salud)'])."</td><td>$".number_format($row['sum(pension)'])."</td>
                        <td>$".number_format($row['sum(fondo)'])."</td><td>$".number_format($row['sum(anticipo)'])."</td>
                        <td>$".number_format($row['sum(pago_v)'])."</td><td>$".number_format($row['sum(desembolso)'])."</td>
                        <td></td><td></td><td></td><td></td>
                        <td></td><td>$".number_format($row['sum(valor_cuota)'])."</td>
                        <td>$".number_format($row['sum(saldo_prestamo)'])."</td><td>$".number_format($row['sum(total_deduccion)'])."</td></tr>"; 

                        ?>
                    </table>
                </div>
            </div>

            <br>
            <table align="center">
                <td><th colspan=2 align='center'><a type='submit' class='btn btn-outline-info' href="formulario.php">Volver</a></th></td>
                <td><th colspan=2 align='center'><a type='submit' class='btn btn-outline-info' href="pdf.php" target="_blank">Descargar</a></th></td>
            </table>
            <br>
    </form>
<?php 
}
?>