<?php 
$nombre = $_POST["nombre"];

array_map('unlink', glob("../usuario/".$nombre."/*.jpg"));
rmdir("../usuario/".$nombre);
?>