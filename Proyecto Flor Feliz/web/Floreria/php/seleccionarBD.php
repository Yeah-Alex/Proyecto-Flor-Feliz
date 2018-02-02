<?php
include "conexionBD.php";

$lista = array();
$sentencia = "SELECT nombre FROM usuario";
$resultado = $conexion->query($sentencia);

if ($resultado->num_rows >0) {
	while($fila = $resultado->fetch_assoc()) {
        $lista[] = $fila["nombre"];
    }
}else{
	echo "Error.";
}

echo json_encode($lista);

$conexion->close();
?>