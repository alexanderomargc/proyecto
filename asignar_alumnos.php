<?php
include('conexion.php');

$usuario_id = 1; // Cambia esto por el ID real de la maestra logueada

$alumnos = [
    ["Juan Pérez", "1º", "A"],
    ["Ana López", "1º", "A"],
    ["Carlos Ramírez", "1º", "A"]
];

foreach ($alumnos as $alumno) {
    $sql = "INSERT INTO alumnos_asignados (nombre, grado, grupo, usuario_id) VALUES (?, ?, ?, ?)";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("sssi", $alumno[0], $alumno[1], $alumno[2], $usuario_id);
    $stmt->execute();
}

echo "Alumnos asignados correctamente.";
?>