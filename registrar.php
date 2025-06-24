<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

include('conexion.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $alumno_id = $_POST['alumno_id'];
    $materia = $_POST['materia'];
    $calificacion = $_POST['calificacion'];
    $usuario_id = $_SESSION['usuario_id'];

    if (!empty($alumno_id) && !empty($materia) && is_numeric($calificacion)) {

        // Obtener datos del alumno asignado
        $query = "SELECT nombre, grado, grupo FROM alumnos_asignados WHERE id = ? AND usuario_id = ?";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param("ii", $alumno_id, $usuario_id);
        $stmt->execute();
        $stmt->bind_result($nombre, $grado, $grupo);
        $stmt->fetch();
        $stmt->close();

        // Verificar si ya existe registro
        $verificar_sql = "SELECT id FROM alumnos WHERE nombre = ? AND materia = ?";
        $verificar_stmt = $conexion->prepare($verificar_sql);
        $verificar_stmt->bind_param("ss", $nombre, $materia);
        $verificar_stmt->execute();
        $verificar_stmt->store_result();

        if ($verificar_stmt->num_rows > 0) {
            echo "<p style='color:red;'>⚠ Ya existe una calificación registrada para este alumno en esta materia.</p>";
        } else {
            // Insertar nuevo registro
            $insert_sql = "INSERT INTO alumnos (nombre, grado, grupo, materia, calificacion, usuario_id)
                           VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conexion->prepare($insert_sql);
            $stmt->bind_param("ssssdi", $nombre, $grado, $grupo, $materia, $calificacion, $usuario_id);

            if ($stmt->execute()) {
                echo "<p style='color:green;'>✅ Calificación registrada correctamente.</p>";
            } else {
                echo "<p style='color:red;'>Error al registrar: " . $stmt->error . "</p>";
            }
            $stmt->close();
        }

        $verificar_stmt->close();
    } else {
        echo "<p style='color:red;'>Por favor, completa todos los campos correctamente.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Calificación</title>
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

<h2>Registrar Calificación</h2>
<form method="POST" action="registrar.php">
    <table border="1" cellpadding="10" cellspacing="0" style="border-collapse: collapse; width: 70%; text-align: center;">
        <tr>
            <th>Datos</th>
            <th>Capturar</th>
        </tr>

        <tr>
            <td><label>Alumno asignado:</label></td>
            <td>
                <select name="alumno_id" required>
                    <option value="">Selecciona un alumno</option>
                    <?php
                    $usuario_id = $_SESSION['usuario_id'];
                    $query = "SELECT id, nombre, grado, grupo FROM alumnos_asignados WHERE usuario_id = ?";
                    $stmt = $conexion->prepare($query);
                    $stmt->bind_param("i", $usuario_id);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='{$row['id']}'>{$row['nombre']} - {$row['grado']}{$row['grupo']}</option>";
                    }
                    ?>
                </select>
            </td>
        </tr>

        <tr>
            <td><label>Materia:</label></td>
            <td>
                <select name="materia" required>
                    <option value="">Selecciona una materia</option>
                    <option value="Educación Socioemocional">Educación Socioemocional</option>
                    <option value="Matemáticas">Matemáticas</option>
                    <option value="Conocimiento del Medio">Conocimiento del Medio</option>
                    <option value="Artes">Artes</option>
                    <option value="Educación Física">Educación Física</option>
                    <option value="Inglés">Inglés</option>
                    <option value="Formación Cívica y Ética">Formación Cívica y Ética</option>
                    <option value="Vida Saludable">Vida Saludable</option>
                </select>
            </td>
        </tr>

        <tr>
            <td><label>Calificación:</label></td>
            <td>
                <select name="calificacion" required>
                    <option value="">Selecciona una calificación</option>
                    <?php
                    for ($i = 1; $i <= 10; $i++) {
                        echo "<option value='$i'>$i</option>";
                    }
                    ?>
                </select>
            </td>
        </tr>

        <tr>
            <td colspan="2" align="center">
                <input type="submit" value="Registrar">
            </td>
        </tr>
    </table>
</form>

<p style="text-align: center;">
    <a href="ver_calificaciones.php">Ver calificaciones registradas</a> |
    <a href="logout.php">Cerrar sesión</a>
</p>

</body>
</html>