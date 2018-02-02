<?php
/*----------------
SI SE INICIO SESION CON ANTERIORIDAD Y NO PRESIONO EL "BOTON SALIR" DE LA PAGINA DEL USUARIO, REDIRECCIONAR INMEDIATAMENTE,PARA NO REALIZAR UNA DOBLE SESION
-----------------*/
session_start();
if(isset($_SESSION['Nombre'])){
	header('Location: usuario.php');
	exit;
}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no">
	<title>La flor feliz</title>
	<link rel="icon" href="../img/favicon.ico" type="image/x-icon" >
	<link rel="stylesheet" type="text/css" href="../css/disenoDeEntrada.css">
	<link rel="stylesheet" type="text/css" href="../css/font.css">
</head>
<body>
<video autoplay loop muted poster="../img/poster_video2.png">
	<source src="../video/video2.mp4" type="video/mp4">
</video>
<section>
	<form action="../php/iniciarSesion.php" method="post">
	<img src="../img/regalo.png" alt="imagen-regalo">
	<?php 
	if(isset($_GET["Exito"])){
		echo "<p>BOOYA!! Te registraste con exito. Puedes iniciar sesion.</p>";
	}
	if(isset($_GET["Error"])){
		echo "<p id='Error'>Verifica tu usuario o contraseña</p>";
	}
	?>
	<input type="text" placeholder="|Nombre" name="Nombre"  required/>
	<input type="password" placeholder="|Contraseña" name="Contrasena"  required/>
	<input type="submit" value="Entrar" name="Entrar" />
	</form>
</section>
</body>
</html>
