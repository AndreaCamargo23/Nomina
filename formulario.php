<!DOCTYPE html>
<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
<meta htto-equiv="Content-Type" content="text/html; charset='UTF-8">
    <title>NOMINA EMPLEADOS</title>
    <script type="text/javascript" Content="text/javascript" src="./js/validar.js"></script>
</head>
<body onload="limpiar();">

<div class="jumbotron bg-info" ><!--Jumbotron -->
        <h1>NOMINA EMPLEADOS</h1>
        <h6>Andrea Camargo, Michael Guzman, Leonar Jejen, Brandon Monroy</h6>
    </div>
    <!--FORMULARIO PARA INGRESAR UN EMPLEADO-->
    <form action="./principal.php" method="POST" name="informacion"><br>
        
        <div class="container-fluid form-row d-flex justify-content-center">
            <div class="form-group col-sm-5 border" >
                <table border="0" align="center" class="table table-hover border-top">
                    <thead><h3 align="center" class="bg-info">INFORMACIÓN GENERAL</h3></thead>
                    <tr><td><label class="form-label">Nombre:</label></td><td><input type="text" class="form-control" name="nom"  required></td></tr>
                    <tr><td>Centro de Costos:</td><td><input type="text" class="form-control" name="cc" required></td></tr>
                    <tr><td>Cargo:</td><td><input type="text" class="form-control" name="cargo"></td></tr>
                    <tr><td>No Identificación:</td><td><input class="form-control" type="number" name="id"  required></td></tr>
                    <tr><td>Sueldo:</td><td><input class="form-control" type="number" name="sueldo"  required></td></tr>
                 </table>
            </div>
        </div>
        <br>
        
        <div class='container-fluid form-row d-flex justify-content-center'>
        
            <div class="form-group col-sm-6 border" >
            <h3 align='center' class="bg-info">DEVENGADOS</h3>
                <table border="0" align="center" class="table table-hover border-top ">
                    <tr>
                    <td>Dias laborados:</td><td><input class="form-control" type="number" name="dias"  style="width:70px; heigth:1px;"></td>
                    <td>Marque una opción: <br></td><td>
                    <input  type="radio" name="vac" value="vacacionesDisfrutadas"> Disfruto vacaciones
                    <br><input type="radio"  name="vac" value="vacacionesCompensadas"> Vacaciones Compensadas
                    <br><input type="radio"  name="vac" value="ninguna"> Ninguna
                    </td></tr>
                    <tr><td>Dias de Vacaciones</td><td><input class="form-control" type="number" name="diasV"  style="width:70px; heigth:1px;" required></td>
                    <td>Dias de Incapacidad</td><td><input class="form-control" type="number" name="incap"  style="width:70px; heigth:1px;" required></td></tr>
                    <tr><td>¿Cuantos extra turno?</td><td><input class="form-control" type="number" name='extra'  style='width:70px; heigth:1px;' required></td>
                    <td>Cantidad de Turnos Noturnos</td><td><input class="form-control" type='number' name='noctur' style='width:70px; heigth:1px;' required></td></tr>
                    <tr><td>Cantidad de dominicales</td><td><input class="form-control" type='text' name='domin' style='width:70px; heigth:1px;' required></td>
                    <td>Aux. Alimentacion no prestacional<br></td><td>
                    <input  type="radio" name="alimentacion" value="si"> Si
                    <br><input type="radio"  name="alimentacion" value="no"> No
                    </td>
                    </tr>
                </table>
            </div>
        
        <div class="form-group col-sm-1"></div>
     
            <div class='form-group col-sm-5 border' >
            <h3 align='center' class="bg-info">DEDUCCIONES</h3>
                <table border='0' align='center' class='table table-hover border-top'>
                    <tr>
                    <td>Valor Anticipo: </td><td>
                    <input class="form-control" type='number' name='anti' required></td></tr>
                    <tr><td>Monto del desembolso: </td><td>
                    <input class="form-control" type='number' name='des' required></td></tr>
                    <tr><td>No Cuotas: </td>
                    <td><input class="form-control" type='number' name='cuotas' style='width:90px; heigth:1px;' required></td></tr>
                    <tr><td>Fecha: </td>
                    <td><input class="form-control" type='date' name='fecha' required></td></tr>
                    <tr><td>No cuota actual: </td>
                    <td><input class="form-control" type='number' name='actual' style='width:90px; heigth:1px;' required></td></tr>
                </table>
            </div>
           
        </div>
        
        <br>
        <table align="center">
        <td><th colspan=2 align='center'><input type='submit' class='btn btn-outline-info' name='ENVIARINFORMACIÓN' value="Insertar Empleado"></th></td><td></td>
        <td><th colspan=2 align='center'><input type='reset' class='btn btn-outline-info' name='LIMPIARFORMULARIO' value="Limpiar Formulario"></th></td>
        <td><th colspan=2 align='center'><a type='submit' class='btn btn-outline-info' name='CONSULTAR' value="Consultar" href="./principal.php">Consultar</a></th></td>
        </table>
        <br>
    </form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
</body>
</html>




