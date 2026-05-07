<?php
// Importamos la conexión
require_once 'config.php';

// Respuesta en formato JSON
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = $_POST['usuario'] ?? '';
    $pass = $_POST['password'] ?? '';

    if (!empty($user) && !empty($pass)) {
        // Buscamos al usuario en la base de datos
        $stmt = $conn->prepare("SELECT * FROM usuarios WHERE usuario = :u");
        $stmt->bindParam(':u', $user);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verificamos existencia y contraseña (usando password_verify para el hash)
        if ($row && password_verify($pass, $row['password'])) {
            echo json_encode([
                "status" => "success",
                "mensaje" => "autenticación satisfactoria"
            ]);
        } else {
            echo json_encode([
                "status" => "error",
                "mensaje" => "error en la autenticación"
            ]);
        }
    } else {
        echo json_encode(["error" => "Campos vacíos"]);
    }
} else {
    echo json_encode(["error" => "Método no permitido"]);
}
?>
