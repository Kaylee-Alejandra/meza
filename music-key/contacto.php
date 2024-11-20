<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto | Tienda de Música</title>
    <link rel="stylesheet" href="styles.css">
    <!-- Agregar Font Awesome para los íconos de redes sociales -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <!-- Estilos adicionales -->
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        header {
            background-color: #333;
            color: white;
            padding: 15px 0;
            text-align: center;
        }

        header h1 {
            margin: 0;
            font-size: 2.5rem;
        }

        section.contacto {
            max-width: 900px;
            margin: 50px auto;
            background-color: white;
            padding: 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        section.contacto h2 {
            font-size: 2rem;
            color: #333;
            margin-bottom: 20px;
        }

        section.contacto p {
            font-size: 1.1rem;
            color: #555;
            line-height: 1.6;
        }

        section.contacto ul {
            list-style-type: none;
            padding: 0;
            margin: 20px 0;
        }

        section.contacto ul li {
            font-size: 1.2rem;
            margin: 10px 0;
        }

        section.contacto ul li a {
            color: #007bff;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s ease;
        }

        section.contacto ul li a:hover {
            color: #0056b3;
        }

        .social-icons {
            margin-top: 30px;
            text-align: center;
        }

        .social-icons a {
            font-size: 2rem;
            color: #333;
            margin: 0 10px;
            transition: color 0.3s ease;
        }

        .social-icons a:hover {
            color: #007bff;
        }

        footer {
            text-align: center;
            padding: 20px;
            background-color: #333;
            color: white;
        }

        footer p {
            margin: 0;
        }
    </style>
</head>
<body>

    <!-- Encabezado -->
    <nav class="navbar">
            <ul>
                <li><a href="index.php">Inicio</a></li>
                <li><a href="login.php">Login</a></li>
                <li><a href="productos.php">Productos</a></li>
                <li><a href="carrito.php">Carrito</a></li>
                <li><a href="contacto.php">Contacto</a></li>
            </ul>
        </nav>
    <header>
        
        <h1>Tienda de Música</h1>
    </header>

    <!-- Sección de Contacto -->
    <section class="contacto">
        <h2>Contacto</h2>
        <p>¡Gracias por visitar nuestra tienda de música! Si tienes alguna consulta o necesitas más información, no dudes en contactarnos.</p>
        
        <p>También puedes seguirnos en nuestras redes sociales:</p>
        <ul>
            <li><a href="https://facebook.com/tiendamusica" target="_blank"><i class="fab fa-facebook"></i> Facebook</a></li>
            <li><a href="https://instagram.com/tiendamusica" target="_blank"><i class="fab fa-instagram"></i> Instagram</a></li>
        </ul>

        <p>Teléfono: <strong>123-456-789</strong></p>
        <p>Email: <strong>info@tiendamusic.com</strong></p>

        <div class="social-icons">
            <a href="https://facebook.com/tiendamusica" target="_blank"><i class="fab fa-facebook"></i></a>
            <a href="https://instagram.com/tiendamusica" target="_blank"><i class="fab fa-instagram"></i></a>
            <a href="https://twitter.com/tiendamusica" target="_blank"><i class="fab fa-twitter"></i></a>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <p>&copy; 2024 Tienda de Música | Todos los derechos reservados.</p>
    </footer>

</body>
</html>
