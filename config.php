<?php
// Configuración de conexión (Ajustado a tus puertos de XAMPP)
$host = "localhost:3308"; // Tu puerto de MySQL es 3308
$db   = "sena_web_service";
$user = "root";
$pass = ""; // Por defecto en XAMPP está vacío

try {
    // Creamos la conexión usando PDO
    $conn = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    // Configuramos para que nos avise si hay errores
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
}
?>
