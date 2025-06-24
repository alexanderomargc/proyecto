<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

include('conexion.php');
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Calificaciones Registradas</title>
    <link rel="stylesheet" type="text/css" href="css/estilos.css">

<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-NF1YFSCKBL"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-NF1YFSCKBL');
</script>

</head>
<body>

<h2>Listado de Calificaciones Registradas</h2>

<!-- FORMULARIO DE FILTRO -->
<form method="GET" action="ver_calificaciones.php" class="form-filtros">
    <label>Grado:
        <select name="grado">
            <option value="">Todos</option>
            <option value="1º">1º</option>
            <option value="2º">2º</option>
            <option value="3º">3º</option>
        </select>
    </label>

    <label>Grupo:
        <select name="grupo">
            <option value="">Todos</option>
            <option value="A">A</option>
            <option value="B">B</option>
            <option value="C">C</option>
        </select>
    </label>

    <label>Materia:
        <select name="materia">
            <option value="">Todas</option>
            <option value="Educación Socioemocional">Educación Socioemocional</option>
            <option value="Matemáticas">Matemáticas</option>
            <option value="Conocimiento del Medio">Conocimiento del Medio</option>
            <option value="Artes">Artes</option>
            <option value="Educación Física">Educación Física</option>
            <option value="Inglés">Inglés</option>
            <option value="Formación Cívica y Ética">Formación Cívica y Ética</option>
            <option value="Vida Saludable">Vida Saludable</option>
        </select>
    </label>

    <input type="submit" value="Filtrar">
</form>

<!-- BOTÓN EXPORTAR A PDF -->
<form method="GET" action="exportar_pdf.php" target="_blank" class="form-filtros">
    <input type="hidden" name="grado" value="<?php echo $_GET['grado'] ?? ''; ?>">
    <input type="hidden" name="grupo" value="<?php echo $_GET['grupo'] ?? ''; ?>">
    <input type="hidden" name="materia" value="<?php echo $_GET['materia'] ?? ''; ?>">
    <input type="submit" value="Exportar a PDF">
</form>

<!-- TABLA DE RESULTADOS -->
<table>
    <tr>
        <th>Alumno</th>
        <th>Grado</th>
        <th>Grupo</th>
        <th>Materia</th>
        <th>Calificación</th>
        <th>Fecha</th>
    </tr>

<?php
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

if ($resultado->num_rows > 0) {
    while ($fila = $resultado->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($fila['nombre']) . "</td>";
        echo "<td>" . htmlspecialchars($fila['grado']) . "</td>";
        echo "<td>" . htmlspecialchars($fila['grupo']) . "</td>";
        echo "<td>" . htmlspecialchars($fila['materia']) . "</td>";
        echo "<td>" . htmlspecialchars($fila['calificacion']) . "</td>";
        echo "<td>" . htmlspecialchars($fila['fecha_registro']) . "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='6'>No hay calificaciones registradas.</td></tr>";
}
?>

</table>

<br>
<p style="text-align: center;">
    <a href="registrar.php">← Volver al formulario</a> |
    <a href="logout.php">Cerrar sesión</a>
</p>

</body>
</html>