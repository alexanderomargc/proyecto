<?php
require_once 'dompdf/autoload.inc.php';
use Dompdf\Dompdf;

session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

include('conexion.php');

$usuario_id = $_SESSION['usuario_id'];
$where = ["usuario_id = $usuario_id"];

if (!empty($_GET['grado'])) {
    $grado = $conexion->real_escape_string($_GET['grado']);
    $where[] = "grado = '$grado'";
}
if (!empty($_GET['grupo'])) {
    $grupo = $conexion->real_escape_string($_GET['grupo']);
    $where[] = "grupo = '$grupo'";
}
if (!empty($_GET['materia'])) {
    $materia = $conexion->real_escape_string($_GET['materia']);
    $where[] = "materia = '$materia'";
}

$filtro = "WHERE " . implode(" AND ", $where);

$sql = "SELECT nombre, grado, grupo, materia, calificacion, fecha_registro
        FROM alumnos
        $filtro
        ORDER BY fecha_registro DESC";

$resultado = $conexion->query($sql);

// Contenido HTML para el PDF
$html = "<h2 style='text-align:center;'>Reporte de Calificaciones</h2>";
$html .= "<table border='1' cellpadding='5' cellspacing='0' width='100%'>
<tr>
    <th>Alumno</th>
    <th>Grado</th>
    <th>Grupo</th>
    <th>Materia</th>
    <th>Calificación</th>
    <th>Fecha</th>
</tr>";

if ($resultado->num_rows > 0) {
    while ($fila = $resultado->fetch_assoc()) {
        $html .= "<tr>
            <td>{$fila['nombre']}</td>
            <td>{$fila['grado']}</td>
            <td>{$fila['grupo']}</td>
            <td>{$fila['materia']}</td>
            <td>{$fila['calificacion']}</td>
            <td>{$fila['fecha_registro']}</td>
        </tr>";
    }
} else {
    $html .= "<tr><td colspan='6'>No hay registros disponibles.</td></tr>";
}

$html .= "</table>";

// Generar el PDF
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'landscape');
$dompdf->render();
$dompdf->stream("reporte_calificaciones.pdf", ["Attachment" => true]);
exit;
