<?php

$servername = "localhost";
$username = "root"; // Usa el mismo usuario de tu .env / Database.php
$password = "";     // Usa la misma contraseña de tu .env / Database.php (vacía en este caso)
$dbname = "tienda_hardware"; // Usa el mismo nombre de BD de tu .env / Database.php

// Crea la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica la conexión
if ($conn->connect_error) {
    die("<h3>¡ERROR DE CONEXIÓN A LA BASE DE DATOS!</h3>" . $conn->connect_error);
}

echo "<h3>¡Conexión a la base de datos exitosa!</h3>";

// Cierra la conexión
$conn->close();

?>