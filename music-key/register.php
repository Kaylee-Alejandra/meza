<?php
// Habilitar la visualización de errores para depuración
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Incluir la conexión a la base de datos
include('db_connect.php');

// Verificar si el formulario de registro ha sido enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $nombre_usuario = $_POST['nombre_usuario'];
    $correo = $_POST['correo'];
    $contrasena = $_POST['contrasena'];

    // Validar que los campos no estén vacíos
    if (!empty($nombre_usuario) && !empty($correo) && !empty($contrasena)) {
        // Verificar si el nombre de usuario o correo ya existen
        $query = "SELECT * FROM usuarios WHERE nombre_usuario = ? OR correo = ?";
        
        // Preparar la consulta
        if ($stmt = $conn->prepare($query)) {
            // Vincular los parámetros
            $stmt->bind_param("ss", $nombre_usuario, $correo);
            
            // Ejecutar la consulta
            $stmt->execute();
            
            // Obtener el resultado
            $result = $stmt->get_result();
            
            // Verificar si ya existe un usuario con ese nombre o correo
            if ($result->num_rows > 0) {
                echo "<p>Este usuario o correo ya está registrado. Por favor, inicia sesión.</p>";
            } else {
                // Cifrar la contraseña
                $contrasena_cifrada = password_hash($contrasena, PASSWORD_DEFAULT);

                // Insertar el nuevo usuario en la base de datos
                $query_insert = "INSERT INTO usuarios (nombre_usuario, correo, contrasena) VALUES (?, ?, ?)";
                if ($stmt_insert = $conn->prepare($query_insert)) {
                    $stmt_insert->bind_param("sss", $nombre_usuario, $correo, $contrasena_cifrada);
                    $stmt_insert->execute();
                    echo "<p>Registro exitoso. Ahora puedes iniciar sesión.</p>";
                } else {
                    echo "<p>Error al registrar el usuario.</p>";
                }
            }
            
            // Cerrar la consulta
            $stmt->close();
        } else {
            echo "<p>Error al preparar la consulta.</p>";
        }
    } else {
        echo "<p>Por favor, completa todos los campos.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Tienda de Música</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            background-color: #333;
            padding: 10px;
            z-index: 10;
        }
        header nav ul {
            list-style: none;
            display: flex;
            justify-content: center;
        }
        header nav ul li {
            margin: 0 15px;
        }
        header nav ul li a {
            text-decoration: none;
            color: white;
            font-size: 16px;
        }
        header nav ul li a:hover {
            text-decoration: underline;
        }

        main {
            width: 100%;
            max-width: 400px;
            margin-top: 60px;
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        
        h2 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
        }

        .register-form label {
            font-weight: bold;
            margin-bottom: 8px;
            display: block;
            color: #333;
        }

        .register-form input {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        .register-form button {
            width: 100%;
            padding: 10px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        .register-form button:hover {
            background-color: #2980b9;
        }

        .error {
            color: red;
            font-size: 14px;
            margin-bottom: 20px;
            text-align: center;
        }

        .register-form p {
            text-align: center;
        }

        .register-form p a {
            color: #3498db;
            text-decoration: none;
        }

        .register-form p a:hover {
            text-decoration: underline;
        }

    </style>
</head>
<body>

    <!-- Barra de navegación -->
    <header>
        <nav class="navbar">
            <ul>
                <li><a href="index.php">Inicio</a></li>
                <li><a href="login.php">Login</a></li>
                <li><a href="productos.php">Productos</a></li>
                <li><a href="carrito.php">Carrito</a></li>
                <li><a href="contacto.php">Contacto</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section class="register-form">
            <h2>Crear Cuenta</h2>

            <?php
            // Mostrar mensaje de error o éxito si existe
            if (isset($error_message)) {
                echo "<p class='error'>$error_message</p>";
            }
            ?>

            <form action="register.php" method="POST">
                <label for="nombre_usuario">Usuario</label>
                <input type="text" id="nombre_usuario" name="nombre_usuario" required>

                <label for="correo">Correo Electrónico</label>
                <input type="email" id="correo" name="correo" required>

                <label for="contrasena">Contraseña</label>
                <input type="password" id="contrasena" name="contrasena" required>

                <button type="submit">Registrarse</button>
            </form>

            <p>¿Ya tienes cuenta? <a href="login.php">Inicia sesión aquí</a></p>
        </section>
    </main>

</body>
</html>
