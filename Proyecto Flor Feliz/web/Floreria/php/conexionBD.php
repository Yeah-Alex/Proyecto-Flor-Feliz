<?php 
$host = "localhost";
$usuario = "root";
$contrasena = "";
$basedatos = "registrar";

$conexion = new mysqli($host,$usuario,$contrasena,$basedatos);
if ($conexion->connect_errno) {
    die("Conexion fallida");
}
?>