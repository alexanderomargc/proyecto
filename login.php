<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" type="text/css" href="css/estilos.css">
    <style>
        .login-container {
            width: 100%;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f4f4f4;
        }

        .login-box {
            background: #fff;
            padding: 30px 40px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            width: 400px;
        }

        .login-box h2 {
            text-align: center;
            margin-bottom: 25px;
            font-size: 24px;
            color: #333;
        }

        .login-box label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
            margin-top: 15px;
        }

        .login-box input[type="text"],
        .login-box input[type="password"] {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .login-box input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-top: 25px;
            background-color: #2e86de;
            color: white;
            font-size: 17px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .login-box input[type="submit"]:hover {
            background-color: #1b4f72;
        }
    </style>

</head>
<body>

<div class="login-container">
    <div class="login-box">
        <h2>Iniciar Sesión</h2>
        <form method="POST" action="procesar_login.php">
            <label for="usuario">Usuario:</label>
            <input type="text" name="usuario" id="usuario" required>

            <label for="contrasena">Contraseña:</label>
            <input type="password" name="contrasena" id="contrasena" required>

            <input type="submit" value="Entrar">
        </form>
    </div>
</div>

</body>

</html>