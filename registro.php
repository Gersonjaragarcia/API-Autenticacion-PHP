<?php
// Importamos la conexión
require_once 'config.php';

// Definimos que la respuesta será JSON
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = $_POST['usuario'] ?? '';
    $pass = $_POST['password'] ?? '';

    if (!empty($user) && !empty($pass)) {
        // Ciframos la contraseña antes de guardarla
        $pass_encriptada = password_hash($pass, PASSWORD_BCRYPT);

        try {
            $stmt = $conn->prepare("INSERT INTO usuarios (usuario, password) VALUES (:u, :p)");
            $stmt->bindParam(':u', $user);
            $stmt->bindParam(':p', $pass_encriptada);
            
            if ($stmt->execute()) {
                echo json_encode(["mensaje" => "Usuario registrado con éxito"]);
            }
        } catch (PDOException $e) {
            echo json_encode(["error" => "El usuario ya existe o hubo un fallo"]);
        }
    } else {
        echo json_encode(["error" => "Datos incompletos"]);
    }
} else {
    echo json_encode(["error" => "Método no permitido"]);
}
?>
