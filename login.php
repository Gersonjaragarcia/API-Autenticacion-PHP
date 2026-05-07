<?php
// 1. Importamos la conexión a la base de datos
require_once 'config.php';

// 2. Establecemos que la respuesta de este servicio será un JSON
header("Content-Type: application/json");

// 3. Verificamos que la petición sea por el método POST (seguridad)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    // Recibimos el usuario y la contraseña enviados por el cliente
    $user = $_POST['usuario'] ?? '';
    $pass = $_POST['password'] ?? '';

    // Validamos que no nos envíen campos vacíos
    if (!empty($user) && !empty($pass)) {
        
        // Consultamos en la base de datos si existe ese nombre de usuario
        $stmt = $conn->prepare("SELECT * FROM usuarios WHERE usuario = :u");
        $stmt->bindParam(':u', $user);
        $stmt->execute();
        $usuario_encontrado = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verificamos si el usuario existe y si la contraseña coincide con el hash guardado
        if ($usuario_encontrado && password_verify($pass, $usuario_encontrado['password'])) {
            // Mensaje de éxito según lo requerido por la actividad GA7-220501096-AA5
            echo json_encode([
                "status" => "success",
                "mensaje" => "autenticación satisfactoria"
            ]);
        } else {
            // Mensaje de error en caso de credenciales incorrectas
            echo json_encode([
                "status" => "error",
                "mensaje" => "error en la autenticación"
            ]);
        }
    } else {
        echo json_encode(["error" => "Campos obligatorios incompletos"]);
    }
} else {
    echo json_encode(["error" => "Método no permitido"]);
}
?>
