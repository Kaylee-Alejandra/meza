<?php
session_start();  // Iniciar la sesión para manejar el carrito

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

// Consultar los productos
$sql = "SELECT id, nombre, descripcion, precio, imagen_url FROM productos LIMIT 5"; // Limitar a 5 productos
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda de Música</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <!-- Barra de navegación -->
    <nav class="navbar">
        <ul>
            <li><a href="index.php">Inicio</a></li>
            <li><a href="login.php">Login</a></li>
            <li><a href="productos.php">Productos</a></li> <!-- Corregido el enlace -->
            <li><a href="carrito.php">Carrito</a></li>
            <li><a href="contacto.php">Contacto</a></li>
        </ul>
    </nav>

    <!-- Encabezado -->
    <header id="inicio">
        <h1>Bienvenidos a la Tienda de Música</h1>
        <p>Encuentra tus instrumentos y accesorios favoritos</p>
    </header>

    <!-- Sección de productos -->
    <section id="productos">
      <center><h2>Productos </h2></center>  

        <div class="producto-lista">
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo '<div class="producto-item">';
                    echo '<img src="' . $row["imagen_url"] . '" alt="' . $row["nombre"] . '">';
                    echo '<h3>' . $row["nombre"] . '</h3>';
                    echo '<p>' . $row["descripcion"] . '</p>';
                    echo '<p class="precio">$' . number_format($row["precio"], 2) . '</p>';
                    ?>
                    <!-- Formulario para agregar al carrito -->
                    <form method="POST" action="productos.php">
                        <input type="hidden" name="producto_id" value="<?php echo $row['id']; ?>">
                        <button type="submit" name="agregar">Agregar al Carrito</button>
                    </form>
                    <?php
                    echo '</div>';
                }
            } else {
                echo '<p>No hay productos disponibles.</p>';
            }
            ?>
        </div>
    </section>

    <!-- Footer con información de contacto -->
    <footer id="contacto">
        <p>Contacto: info@tiendamusic.com | Teléfono: 123-456-789</p>
    </footer>

</body>
</html>

<?php
// Cerrar conexión
$conn->close();
?>
