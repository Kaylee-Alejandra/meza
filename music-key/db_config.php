<?php
// db_config.php

// Configuración de la base de datos
$servername = "localhost";  // El servidor de base de datos, normalmente "localhost" si trabajas de manera local
$username = "root";         // Nombre de usuario para MySQL (en local puede ser "root")
$password = "";             // Contraseña para MySQL (vacío en entorno local por defecto, si tienes contraseña, agrégala aquí)
$dbname = "tienda_musica";  // Nombre de la base de datos a la que nos conectamos

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Comprobar si hubo un error de conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);  // Muestra el error si no se pudo conectar
}

// Si la conexión fue exitosa, puedes realizar consultas a la base de datos
?>
