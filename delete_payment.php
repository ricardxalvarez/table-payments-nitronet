<?php
require_once('config.php'); // Asegúrate de que este archivo contiene la configuración de conexión a la base de datos

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];

    try {
        // Preparar la consulta SQL para eliminar el registro
        $sql = "DELETE FROM payments WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        // Respuesta de éxito
        http_response_code(200);
        echo "Pago eliminado correctamente";
    } catch (PDOException $e) {
        // Respuesta de error
        http_response_code(500);
        echo "Error al eliminar el pago: " . $e->getMessage();
    }
} else {
    // Si no se proporciona el ID, responder con error
    http_response_code(400);
    echo "ID del pago no proporcionado";
}
?>
