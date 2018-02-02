<?php 
$fecha = date('r');
$nombre = $_POST["nombre"];

copy("../usuario/imagen.jpg", "../usuario/".$nombre."/".$fecha.".jpg");
unlink("../usuario/imagen.jpg");

?>
