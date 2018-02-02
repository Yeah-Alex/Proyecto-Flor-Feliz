<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, user-scalable=no">
	<title>La flor feliz</title>
	<link rel="icon" href="img/favicon.ico" type="image/x-icon" >
	<link rel="stylesheet" type="text/css" href="css/disenoDeIndex.css">
	<link rel="stylesheet" type="text/css" href="css/font.css">
	<script type="text/javascript" src="js/titulo.js"></script>
</head>
<body>
<video autoplay loop muted poster="img/poster_video1.png">
	<source src="video/video1.mp4" type="video/mp4">
</video>
<div id="fondoOpaco"></div>
<nav>
	<ul>
	<li><a href="paginas/entrar.php">Entrar</a></li>
		<li><a href="#">Acerca</a></li>
		<li><a href="#">Contacto</a></li>
	</ul>
</nav>
<section>
	<h1>La flor feliz ]</h1>
	<form action=<?php echo "\"".htmlspecialchars($_SERVER['PHP_SELF'])."\"";?> method="post">

		<?php 
		if(isset($_POST["Registrar"])){
			include 'php/insertarBD.php'; 	
		}
		if(isset($_GET["Error"])){
			echo "<p>UPSS! Este usuario ya existe. Vuelve a intentarlo.</p>";
		}
		?>
		<div>
		<input type="text" placeholder="|Nombre" name="Nombre" required />
		<input type="password" placeholder="|Contraseña" name="Contrasena" required />
		<input type="submit" value="*Registrar" name="Registrar" />
		</div>
	</form>
</section>
<footer>
	
</footer>
</body>
</html>
