<?php
session_start();
include('conexion.php');

$usuario = $_POST['usuario'];
$contrasena = $_POST['contrasena'];

$sql = "SELECT id, nombre, contrasena FROM usuarios WHERE usuario = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("s", $usuario);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 1) {
    $stmt->bind_result($id, $nombre, $hash);
    $stmt->fetch();

    if (password_verify($contrasena, $hash)) {
        $_SESSION['usuario_id'] = $id;
        $_SESSION['usuario_nombre'] = $nombre;
        header("Location: registrar.php");
        exit;
    } else {
        echo "❌ Contraseña incorrecta.";
    }
} else {
    echo "❌ Usuario no encontrado.";
}
?>