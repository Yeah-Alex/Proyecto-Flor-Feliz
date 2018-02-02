<?php
session_start();

if (!$_SESSION) {
	salir();
}else{
	salir();
}

function salir()
{
$_SESSION = array();
session_destroy();
header('Location: ../');
exit;
}

?>