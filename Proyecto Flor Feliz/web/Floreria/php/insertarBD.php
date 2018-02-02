<?php
include 'conexionBD.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['Nombre']!="" && $_POST['Contrasena']!="") {
	$nombre = filtrar($_POST['Nombre']);
	$contrasena = filtrar($_POST['Contrasena']);
	$ok = false;


	$sentencia = "SELECT nombre FROM usuario WHERE nombre='".$nombre."'";
	$resultado = $conexion->query($sentencia);

	if($resultado->num_rows > 0){
		$ok = false;
	}else{
		$sentencia = "INSERT INTO usuario(nombre,contrasena) VALUES('".$nombre."','".$contrasena."')";
		$conexion->query($sentencia);
		$ok=true;
	}
			
	$conexion->close();
}else{
	$ok = false;
}

if ($ok == true) {
	header('Location: paginas/entrar.php?Exito="Exito"');
		exit;
}else{
	header('Location: ?Error="Error"');
		exit;
}

function filtrar($dato){
   $dato = trim($dato);
   $dato = stripslashes($dato);
   $dato = htmlspecialchars($dato);
   return $dato;
}

?>