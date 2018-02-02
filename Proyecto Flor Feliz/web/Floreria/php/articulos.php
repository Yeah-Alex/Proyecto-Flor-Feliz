<?php
include 'conexionBD.php';
/*----------------
> CUANDO NO SE ENCUENTREN IMAGENES DENTRO DE LA CARPETA DEL USUARIO, SE INTUYE QUE NO A LLEGADO SU PEDIDO A UN LUGAR Y SE IMPRIME UN MENSAJE
> SI SE ENCUENTRAN SE IMPRIME UN MENSAJE
-----------------*/
if(!glob("../usuario/".$_SESSION['Nombre']."/*.jpg")){
	
echo "<h3>No tienes ninguna compra.</h3>";

}else{
	echo "<h3>Tu pedido a llegado a los siguintes lugares.</h3>";
}

/*----------------
SI HAY IMAGENES DENTRO DE LA CARPETA SE MUESTRAN CADA IMAGEN CON INFORMACION
-----------------*/
foreach (glob("../usuario/".$_SESSION['Nombre']."/*.jpg") as $nombre_fichero){

	error_reporting(0);
	$array = exif_read_data ($nombre_fichero);
	$fecha = $array["DateTimeOriginal"];

	echo '<article>
		<img src="'.$nombre_fichero.'">
		<p><strong>Pais:</strong> Mexico</p>
		<p><strong>Fecha y hora: </strong> '.date ("F d Y H:i:s.", filemtime($nombre_fichero)).'</p>
		<span>&#10004;</span>
	 </article>';
}

?>
