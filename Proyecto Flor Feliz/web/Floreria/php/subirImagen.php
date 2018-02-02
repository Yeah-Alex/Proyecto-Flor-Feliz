<?php
$fecha = date('dFY');
$imagen = $_POST["imagen"];
$nombre = $_POST["nombre"];

$decodificar = base64_decode($imagen);

file_put_contents("../usuario/imagen.jpg", $decodificar);


/*
$array = [
    "nombre" => "mi-nombre",
    "imagen" => "demo",
];
$jsonD = json_encode($array);
echo json_decode($jsonD)->nombre;*/
?>
