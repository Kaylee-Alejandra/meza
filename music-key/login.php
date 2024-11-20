<?php
// Habilitar la visualización de errores para depuración
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Incluir la conexión a la base de datos
include('db_connect.php');

// Verificar si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $nombre_usuario = $_POST['nombre_usuario'];
    $contrasena = $_POST['contrasena'];

    // Validar que los campos no estén vacíos
    if (!empty($nombre_usuario) && !empty($contrasena)) {
        
        // Consulta SQL para obtener el usuario
        $query = "SELECT * FROM usuarios WHERE nombre_usuario = ?";
        
        // Preparar la consulta
        if ($stmt = $conn->prepare($query)) {
            // Vincular los parámetros
            $stmt->bind_param("s", $nombre_usuario);
            
            // Ejecutar la consulta
            $stmt->execute();
            
            // Obtener el resultado
            $result = $stmt->get_result();
            
            // Verificar si se encontró un usuario
            if ($result->num_rows > 0) {
                // Obtener los datos del usuario
                $row = $result->fetch_assoc();
                
                // Verificar si la contraseña coincide usando password_verify()
                if (password_verify($contrasena, $row['contrasena'])) {
                    // La contraseña es correcta, iniciar sesión
                    session_start(); // Iniciar sesión
                    $_SESSION['usuario_id'] = $row['id']; // Guardar ID de usuario
                    $_SESSION['nombre_usuario'] = $row['nombre_usuario']; // Guardar nombre de usuario
                    
                    // Redirigir al productos.php si está autenticado
                    header("Location: productos.php"); 
                    exit();
                } else {
                    $error_message = "Contraseña incorrecta.";
                }
            } else {
                $error_message = "El nombre de usuario no existe.";
            }
        } else {
            $error_message = "Error al preparar la consulta.";
        }
    } else {
        $error_message = "Por favor ingresa tu nombre de usuario y contraseña.";
    }
    
    // Cerrar la conexión
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Tienda de Música</title>
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

        .login-form label {
            font-weight: bold;
            margin-bottom: 8px;
            display: block;
            color: #333;
        }

        .login-form input {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        .login-form button {
            width: 100%;
            padding: 10px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        .login-form button:hover {
            background-color: #2980b9;
        }

        .error {
            color: red;
            font-size: 14px;
            margin-bottom: 20px;
            text-align: center;
        }

        .login-form p {
            text-align: center;
        }

        .login-form p a {
            color: #3498db;
            text-decoration: none;
        }

        .login-form p a:hover {
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
        <section class="login-form">
            <h2>Iniciar Sesión</h2>

            <?php
            if (isset($error_message)) {
                echo "<p class='error'>$error_message</p>";
            }
            ?>

            <form action="login.php" method="POST">
                <label for="nombre_usuario">Usuario</label>
                <input type="text" id="nombre_usuario" name="nombre_usuario" required>

                <label for="contrasena">Contraseña</label>
                <input type="password" id="contrasena" name="contrasena" required>

                <button type="submit">Iniciar sesión</button>
            </form>

            <p>No tienes cuenta? <a href="register.php">Regístrate aquí</a></p>
        </section>
    </main>

</body>
</html>
