<?php
session_start(); // Iniciar sesión

// Conexión a la base de datos
include('db_config.php');

// Verificar si se ha agregado un producto al carrito
if (isset($_POST['agregar'])) {
    $producto_id = $_POST['producto_id'];
    $sql = "SELECT * FROM productos WHERE id = $producto_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $producto = $result->fetch_assoc();
        // Si el producto ya está en el carrito, aumentamos la cantidad
        if (isset($_SESSION['carrito'][$producto_id])) {
            $_SESSION['carrito'][$producto_id]['cantidad']++;
        } else {
            // Si no está en el carrito, lo agregamos
            $_SESSION['carrito'][$producto_id] = [
                'nombre' => $producto['nombre'],
                'precio' => $producto['precio'],
                'cantidad' => 1,
                'imagen' => $producto['imagen_url']
            ];
        }
    }
}

// Consultar los productos disponibles
$sql = "SELECT id, nombre, descripcion, precio, imagen_url FROM productos WHERE disponible = 1 LIMIT 6"; // Cambiar la consulta según sea necesario
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda de Música</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Estilo general de la página */
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            color: #333;
        }

        /* Barra de navegación */
        nav {
            background-color: #333;
            padding: 15px 0;
            position: fixed;
            width: 100%;
            top: 0;
            left: 0;
            z-index: 1000;
        }
        nav a {
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            margin-right: 10px;
            font-size: 16px;
            border-radius: 5px;
        }
        nav a:hover {
            background-color: #555;
        }
        nav .logo {
            font-size: 24px;
            font-weight: bold;
            margin-left: 20px;
        }

        /* Carrusel */
        #carousel {
            margin-top: 80px; /* Para que no se solape con la barra de navegación */
            width: 100%;
            overflow: hidden;
            position: relative;
        }
        .carousel-images {
            display: flex;
            transition: transform 1s ease-in-out;
        }
        .carousel-images img {
            width: 100%;
            height: 500px;
            object-fit: cover;
        }
        .carousel-caption {
            position: absolute;
            top: 20%;
            left: 50%;
            transform: translateX(-50%);
            color: white;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
            text-align: center;
        }
        .carousel-caption h2 {
            font-size: 3rem;
        }
        .carousel-caption p {
            font-size: 1.5rem;
        }

        /* Productos destacados */
        .products-section {
            padding: 50px 20px;
            text-align: center;
        }
        .products-section h2 {
            font-size: 2.5rem;
            margin-bottom: 30px;
            color: #333;
        }
        .product-cards {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            gap: 30px;
            margin-top: 30px;
        }
        .product-card {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            width: 300px;
            overflow: hidden;
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .product-card:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 16px rgba(0,0,0,0.2);
        }
        .product-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        .product-card h3 {
            font-size: 1.5rem;
            margin: 20px 0;
            color: #333;
        }
        .product-card p {
            color: #777;
            font-size: 1rem;
            padding: 0 15px;
        }
        .product-card .price {
            font-size: 1.3rem;
            font-weight: bold;
            color: #e74c3c;
            margin: 15px 0;
        }
        .product-card button {
            padding: 10px 20px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-bottom: 20px;
            transition: background-color 0.3s;
        }
        .product-card button:hover {
            background-color: #2980b9;
        }

        /* Footer */
        footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 20px 0;
            position: relative;
            bottom: 0;
            width: 100%;
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

    <!-- Carrusel -->
    <div id="carousel">
        <div class="carousel-images">
            <img src="images/bili.jpg" alt="Oferta 1">
            <img src="images/motomoto.jpg" alt="Oferta 2">
            <img src="images/elmat.jpg" alt="Oferta 3">
            <img src="images/logo.jpeg" alt="Oferta 4">
            <img src="images/ini.jpeg" alt="Oferta 5">
        </div>
        <div class="carousel-caption">
            <h2>Ofertas Exclusivas</h2>
            <p>Descuentos de hasta un 50% en productos seleccionados</p>
        </div>
    </div>

    <!-- Productos Destacados -->
    <section class="products-section">
        
        <center><div class="product-cards">
        <h1>Informacion sobre nosotros: </h1>
        <H3>Somos una tienda de musica inline que busca que encuentres lo mejor en: <br>
             Guitarras electricas, pianos, Microfonos, Auriculares, Bajo electrito y mas<br>
             Tambien encuentra los discos de tus artistas favoritos
    </H3>

        </div></center>
    </section>

    <!-- Footer -->
    <footer>
        <p>Contacto: Kaylee Alejandra Luevano Molina 5-J| Teléfono: 123-456-789</p>
    </footer>

    <!-- Cerrar conexión -->
    <?php
    $conn->close();
    ?>

    <!-- Carrusel JavaScript -->
    <script>
        let currentIndex = 0;
        const images = document.querySelectorAll('.carousel-images img');
        const totalImages = images.length;

        function changeImage() {
            currentIndex = (currentIndex + 1) % totalImages;
            document.querySelector('.carousel-images').style.transform = `translateX(-${currentIndex * 100}%)`;
        }

        setInterval(changeImage, 2000); // Cambiar imagen cada 2 segundos
    </script>

</body>
</html>
