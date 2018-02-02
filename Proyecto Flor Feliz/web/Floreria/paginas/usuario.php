<?php
/*----------------
SI SE ENTRA A LA PAGINA SIN HABER INICIADO SESION, SE REDIRECCIONARA A LA PAGINA PRINCIPAL
-----------------*/
session_start();
	if (!$_SESSION){
	$_SESSION = array();
	session_destroy();
	header('Location: ../');
	exit;
}
/*----------------
SI SE ENTRA POR PRIMERA VEZ SE CREA UNA CARPETA DONDE SE GUARDARAN LAS FOTOS TOMADAS, SI YA EXISTE NO SE VUELVE A CREAR
-----------------*/
if(!file_exists("../usuario/".$_SESSION['Nombre'])){
	mkdir("../usuario/".$_SESSION['Nombre']);
}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no">
	<title>La flor feliz</title>
	<link rel="icon" href="img/favicon.ico" type="image/x-icon" >
	<link rel="stylesheet" type="text/css" href="../css/disenoDeUsuario.css">
	<link rel="stylesheet" type="text/css" href="../css/font.css">
	<script type="text/javascript" src="../js/titulos.js"></script>
</head>
<body>
<nav>
	<ul>
		<li><a href="../">La flor feliz ]</a></li>
		<li><a id="botonSalida" href="../php/cerrarSesion.php">Salir</a></li>
	</ul>
</nav>
<section>
	<?php 
	echo "<h2>| Bienvenido ".$_SESSION['Nombre'].".</h2>";
	
	include '../php/articulos.php';
	?>
</section>

</body>
</html>