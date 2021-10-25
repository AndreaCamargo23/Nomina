<?php
function conectar(){
    //Variables de conexion
    $host = "localhost:33065";//nombre del servidor de base de datos
    $user="root";
    $pass="";
    $db_name="nomina"; 
    //conectar la base de datos 
    //entra al servidor 
    $link=mysqli_connect($host,$user,$pass) //genera la conexion 
    or die ("ERROR AL CONECTAR LA BD ".mysqli_error($link));//Si no se genera el error lo muestra con
    //seleccionar la BD es decir hacer el USE
    mysqli_select_db($link,$db_name) 
    or die("ERROR AL SELECCIONAR LA BD ".mysqli_error($link));
    return $link;
}
?>