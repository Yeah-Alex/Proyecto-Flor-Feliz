<?php 
include '../php/conexionBD.php';

$nombre = $contrasena = $ok ="";


/*------------------------
SE COMPRUEBA QUE LOS DATOS NO ESTEN VACIOS Y SE HAYA UTILIZADO EL METODO POST
------------------------*/
if ($_POST['Nombre']!="" && $_POST['Contrasena']!="" && $_SERVER["REQUEST_METHOD"] == "POST") {
	
	$nombre = filtrar($_POST['Nombre']);
	$contrasena = filtrar($_POST['Contrasena']);
	$ok = true;

}else{
	header('Location: ../');
	exit;
}

/*------------------------
SI TODO ESTA BIEN SE CREA LA SENTENCIA , SE ENVIA Y SE REGRESA UN RESULTADO QUE SE GUARDA EN LA VARIABLE "$resultado"
------------------------*/
if($ok){
	$sentencia = "SELECT * FROM usuario WHERE nombre='".$nombre."'";
}else{
	$ok=false;
	salir();
}

/*------------------------
SE COMPRUEBA QUE EL REGISTRO QUE ESTAMOS BUSCADO SE ENCUENTRE EN LA BASE DE DATOS
------------------------*/
if($conexion->query($sentencia)){
	$resultado = $conexion->query($sentencia);
}else{
	$ok=false;
	salir();
}


/*------------------------
SE COMPRUEBA QUE EL RESULTADO OBTENIDO SOLO SEA UNO, SI ES ASI SE CREARA UNA VARIABLE PARA RECORRER EL REGISTRO
------------------------*/
if ($resultado->num_rows == 1) {
	$fila = $resultado->fetch_assoc();
}else{
	$ok=false;
	salir();
}

/*------------------------
SE COMPARARN LOS RESULTADO OBTENIDOS DE LA BASE DE DATOS Y LOS DATOS PUESTOS EN EL FORMULARIO
------------------------*/
if($fila['nombre']===$nombre && $fila['contrasena']===$contrasena){
	$ok=true;
}else{
	$ok=false;
	salir();
}

/*------------------------
SI TODO SE A REALIZADO CORRECTAMENTE SE INICIAR SESION EN LA PAGINA "exito.php"
------------------------*/
if($ok){
	$conexion->close();
	unset($_POST);
	session_start();
	$_SESSION['Nombre'] = $nombre;
	header('Location: ../paginas/usuario.php');
	exit;
}else{
	$ok=false;
	salir();
}




function filtrar($dato){
   $dato = trim($dato);
   $dato = stripslashes($dato);
   $dato = htmlspecialchars($dato);
   return $dato;
}

function salir(){
	header('Location: ../paginas/entrar.php?Error="Error"');
	$conexion->close();
	exit;
}
?>