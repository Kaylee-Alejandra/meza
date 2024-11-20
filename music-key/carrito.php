<?php
// Iniciar sesión
session_start();

// Incluir la configuración de la base de datos
include('db_config.php');

// Eliminar producto del carrito
if (isset($_POST['eliminar'])) {
    $producto_id = $_POST['producto_id'];
    unset($_SESSION['carrito'][$producto_id]);  // Eliminar el producto del carrito
    header("Location: carrito.php"); // Redirigir para actualizar el carrito
    exit();
}

// Vaciar el carrito
if (isset($_POST['vaciar'])) {
    unset($_SESSION['carrito']);  // Vaciar todos los productos del carrito
    echo '<script>alert("Carrito vaciado exitosamente.");</script>';  // Alerta para informar al usuario
    header("Location: carrito.php");
    exit();
}

// Calcular el total del carrito
$total = 0;
if (isset($_SESSION['carrito'])) {
    foreach ($_SESSION['carrito'] as $producto) {
        $total += $producto['precio'] * $producto['cantidad'];
    }
}

// Procesar el pago (ventana emergente al presionar "Pagar")
if (isset($_POST['pagar'])) {
    // Mostrar la alerta de éxito en el pedido
    echo '<script>
        alert("El pedido ha sido realizado con éxito");
        window.location.href = "carrito.php";  // Redirigir al carrito
    </script>';
    // Vaciar el carrito después de realizar el pedido
    unset($_SESSION['carrito']);
    exit();  // Salir para evitar que se ejecute el código posterior
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tu Carrito</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Estilos generales para el carrito */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            margin-top: 20px;
            color: #333;
        }

        .navbar {
            background-color: #333;
            padding: 10px;
        }

        .navbar ul {
            list-style: none;
            text-align: center;
            margin: 0;
            padding: 0;
        }

        .navbar ul li {
            display: inline;
            margin-right: 15px;
        }

        .navbar ul li a {
            color: white;
            text-decoration: none;
            font-size: 16px;
        }

        .navbar ul li a:hover {
            text-decoration: underline;
        }

        .carrito-items {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
        }

        .producto {
            width: 80%;
            display: flex;
            flex-direction: row;
            align-items: center;
            background-color: #fff;
            padding: 15px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .producto-imagen {
            width: 150px;
            height: 150px;
            object-fit: cover; /* Mantiene las imágenes con el mismo tamaño y recorta si es necesario */
            margin-right: 20px;
            border-radius: 8px;
        }

        .producto p {
            margin: 5px 0;
            color: #333;
        }

        .boton-eliminar, .boton-vaciar, .boton-pagar {
            background-color: #e74c3c;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 10px;
        }

        .boton-eliminar:hover, .boton-vaciar:hover, .boton-pagar:hover {
            background-color: #c0392b;
        }

        .boton-vaciar, .boton-pagar {
            background-color: #3498db;
            margin-top: 20px;
        }

        .boton-vaciar:hover, .boton-pagar:hover {
            background-color: #2980b9;
        }

        .total {
            text-align: center;
            font-size: 20px;
            margin-top: 20px;
            color: #333;
        }
    </style>
</head>
<body>

    <!-- Barra de navegación -->
    <nav class="navbar">
        <ul>
            <li><a href="index.php">Inicio</a></li>
            <li><a href="login.php">Login</a></li>
            <li><a href="productos.php">Productos</a></li>
            <li><a href="carrito.php">Carrito</a></li>
            <li><a href="contacto.php">Contacto</a></li>
        </ul>
    </nav>

    <!-- Título -->
    <h1>Tu Carrito de Compras</h1>

    <!-- Mostrar productos en el carrito -->
    <?php
    if (isset($_SESSION['carrito']) && !empty($_SESSION['carrito'])) {
        echo '<div class="carrito-items">'; // Contenedor para los productos
        foreach ($_SESSION['carrito'] as $producto_id => $producto) {
            echo '<div class="producto">';
            echo '<img src="' . $producto['imagen'] . '" alt="' . $producto['nombre'] . '" class="producto-imagen">';  // Imagen del producto
            echo '<div>';
            echo '<p><strong>Producto:</strong> ' . $producto['nombre'] . '</p>';
            echo '<p><strong>Precio:</strong> $' . number_format($producto['precio'], 2) . '</p>';
            echo '<p><strong>Cantidad:</strong> ' . $producto['cantidad'] . '</p>';
            
            // Formulario para eliminar el producto
            echo '<form method="POST" action="carrito.php">';
            echo '<input type="hidden" name="producto_id" value="' . $producto_id . '">';
            echo '<button type="submit" name="eliminar" class="boton-eliminar">Eliminar</button>';
            echo '</form>';
            echo '</div>';
            echo '</div>';
        }
        echo '</div>'; // Cierre del contenedor de productos
        
        // Mostrar el total
        echo '<div class="total"><h3>Total: $' . number_format($total, 2) . '</h3></div>';

        // Botón para vaciar el carrito
        echo '<form method="POST" action="carrito.php">';
        echo '<button type="submit" name="vaciar" class="boton-vaciar">Vaciar Carrito</button>';
        echo '</form>';

        // Botón de Pagar
        echo '<form method="POST" action="carrito.php">';
        echo '<button type="submit" name="pagar" class="boton-pagar">Pagar</button>';
        echo '</form>';
    } else {
        echo '<p>Tu carrito está vacío.</p>';
    }
    ?>

</body>
</html>

