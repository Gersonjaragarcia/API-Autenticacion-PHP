<?php
// 1. Incluimos la conexión que se creo 
require_once 'config.php';

// 2. Definimos que la respuesta será en formato JSON (estándar de servicios web)
header("Content-Type: application/json");

// 3. Verificamos que los datos lleguen por el método POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    // Recibimos el usuario y la contraseña
    $user = $_POST['usuario'] ?? '';
    $pass = $_POST['password'] ?? '';

    // Validamos que los campos no estén vacíos
    if (!empty($user) && !empty($pass)) {
        
        // Ciframos la contraseña por seguridad (nunca se guardan en texto plano)
        $pass_encriptada = password_hash($pass, PASSWORD_BCRYPT);

        try {
            // Preparamos la consulta SQL para evitar ataques de inyección
            $stmt = $conn->prepare("INSERT INTO usuarios (usuario, password) VALUES (:u, :p)");
            $stmt->bindParam(':u', $user);
            $stmt->bindParam(':p', $pass_encriptada);
            
            // Ejecutamos la inserción
            if ($stmt->execute()) {
                echo json_encode(["mensaje" => "Usuario registrado con éxito"]);
            }
        } catch (PDOException $e) {
            // Si el nombre de usuario ya existe (es UNIQUE) nos dará error
            echo json_encode(["error" => "El usuario ya existe o hubo un fallo: " . $e->getMessage()]);
        }
    } else {
        echo json_encode(["error" => "Por favor, complete todos los campos"]);
    }
} else {
    // Si alguien intenta entrar desde el navegador directamente sin enviar datos
    echo json_encode(["error" => "Método no permitido. Use POST."]);
}
?>
