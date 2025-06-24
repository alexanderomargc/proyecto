<?php
include('conexion.php');

$nombre = "Amalia Hernandez Juarez";
$usuario = "ama.her";
$contrasena_plana = "12345";
$contrasena_hash = password_hash($contrasena_plana, PASSWORD_DEFAULT);

$sql = "INSERT INTO usuarios (nombre, usuario, contrasena) VALUES (?, ?, ?)";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("sss", $nombre, $usuario, $contrasena_hash);
$stmt->execute();

echo "Usuario creado correctamente.";
?>