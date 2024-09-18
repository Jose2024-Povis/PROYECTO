<?php

$conexion = mysqli_connect("localhost", "root", "", "base");

// Verificar la conexión
if (!$conexion) {
    die("Conexión fallida: " . mysqli_connect_error());
}
echo "Conexión exitosa";

?>
