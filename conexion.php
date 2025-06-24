<?php
$host = "localhost";
$usuario = "root";
$contrasena = "root"; // Por defecto en MAMP, es "root"
$bd = "calificaciones_db";
$puerto = "8889"; // Puerto MySQL en MAMP

$conexion = new mysqli($host, $usuario, $contrasena, $bd, $puerto);

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}
?>