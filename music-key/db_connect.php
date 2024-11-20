<?php
// db_connect.php

$servername = "localhost";    // Dirección del servidor de base de datos
$username = "root";           // Tu usuario de la base de datos (o el que uses)
$password = "";               // Tu contraseña de la base de datos (si tienes una)
$dbname = "tienda_musica";    // Nombre de la base de datos

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
