<?php
// Configuración actualizada al puerto que muestra tu XAMPP ahora (3306)
$host = "localhost:3306"; 
$db   = "sena_web_service";
$user = "root";
$pass = ""; 

try {
    $conn = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
?>


