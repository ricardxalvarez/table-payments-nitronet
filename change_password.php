<?php
session_start();
require_once('config_db.php');

// Función para verificar las respuestas a las preguntas de seguridad
function verifySecurityQuestions($pdo, $username, $answers)
{
    try {
        // Consultar las respuestas guardadas en la base de datos
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Consultar las preguntas y respuestas almacenadas en la tabla questions
            $stmt_questions = $pdo->prepare("SELECT * FROM questions");
            $stmt_questions->execute();
            $questions = $stmt_questions->fetchAll(PDO::FETCH_ASSOC);

            $correct_answers = 0;
            foreach ($questions as $index => $question) {
                if (isset($answers[$index]) && $answers[$index] === $question['answer_text']) {
                    $correct_answers++;
                }
            }

            // Verificar si todas las respuestas son correctas
            if ($correct_answers === count($questions)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false; // Usuario no encontrado
        }
    } catch (PDOException $e) {
        die("Error al verificar las respuestas: " . $e->getMessage());
    }
}

// Verificar inicio de sesión
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["login"])) {
    try {
        // Obtener datos del formulario
        $username = $_POST["username"];
        $password = $_POST["password"];

        // Consultar la base de datos para verificar las credenciales
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Verificar la contraseña utilizando password_verify()
            if (password_verify($password, $user['password'])) {
                // Iniciar sesión
                $_SESSION['username'] = $username;

                // Redirigir al usuario a table-payments.php después de iniciar sesión
                header("Location: table-payments.php");
                exit;
            } else {
                echo "Contraseña incorrecta.";
            }
        } else {
            echo "Usuario no encontrado.";
        }

    } catch (PDOException $e) {
        die("Error al conectar a la base de datos: " . $e->getMessage());
    }
}

// Cambiar contraseña
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["change_password"])) {
    try {
        // Obtener datos del formulario
        $username = $_POST["username"];
        $answers = $_POST["answers"];
        $new_password = $_POST["new_password"];

        // Verificar respuestas a las preguntas de seguridad
        if (verifySecurityQuestions($pdo, $username, $answers)) {
            // Generar hash de la nueva contraseña
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

            // Actualizar la contraseña en la base de datos
            $stmt_update = $pdo->prepare("UPDATE users SET password = ? WHERE username = ?");
            $stmt_update->execute([$hashed_password, $username]);

            // Verificar si se realizó la actualización correctamente
            if ($stmt_update->rowCount() > 0) {
                // Establecer mensaje de éxito
                $_SESSION['change_password_message'] = "Contraseña cambiada exitosamente.";
            } else {
                // Establecer mensaje de error
                $_SESSION['change_password_error'] = "No se pudo cambiar la contraseña.";
            }

            // Redirigir al index.php para mostrar el mensaje
            header("Location: index.php");
            exit;
        } else {
            // Establecer mensaje de error
            $_SESSION['change_password_error'] = "Respuestas incorrectas a las preguntas de seguridad.";
            header("Location: index.php");
            exit;
        }

    } catch (PDOException $e) {
        die("Error al cambiar la contraseña: " . $e->getMessage());
    }
}

?>
