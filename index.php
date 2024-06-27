<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login y Cambio de Contraseña</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h2 class="mb-4">Login y Cambio de Contraseña</h2>
        <form id="loginForm" method="post" action="login.php">
            <div class="form-group">
                <label for="username">Usuario:</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Contraseña:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary" name="login">Iniciar Sesión</button>
            <button type="button" class="btn btn-link" id="changePasswordBtn">Cambiar Contraseña</button>
        </form>
    </div>

    <div class="container mt-5">
        <?php
        // Mostrar mensaje de éxito si existe en la sesión
        if (isset($_SESSION['change_password_message'])) {
            echo '<div class="alert alert-success">' . $_SESSION['change_password_message'] . '</div>';
            unset($_SESSION['change_password_message']); // Limpiar mensaje después de mostrarlo
        }

        // Mostrar mensaje de error si existe en la sesión
        if (isset($_SESSION['change_password_error'])) {
            echo '<div class="alert alert-danger">' . $_SESSION['change_password_error'] . '</div>';
            unset($_SESSION['change_password_error']); // Limpiar mensaje después de mostrarlo
        }
        ?>

    </div>

    <!-- Modal para cambiar contraseña -->
    <div class="modal fade" id="changePasswordModal" tabindex="-1" role="dialog" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="changePasswordModalLabel">Cambiar Contraseña</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="changePasswordForm" method="post" action="change_password.php">
                        <!-- Campos del formulario para cambiar la contraseña -->
                        <div class="form-group">
                            <label for="change_username">Usuario:</label>
                            <input type="text" class="form-control" id="change_username" name="username" required>
                        </div>
                        <?php
                        // Preguntas de seguridad
                        $questions = [
                            "¿Cuál es tu color favorito?",
                            "¿Cuál es el nombre de tu primera mascota?",
                            "¿Dónde nació tu madre?",
                            "¿Cuál es tu película favorita?",
                            "¿Cuál es tu comida favorita?"
                        ];

                        // Mostrar preguntas y campos de respuestas
                        foreach ($questions as $index => $question) {
                            echo '<div class="form-group">';
                            echo '<label for="change_answer' . ($index + 1) . '">' . htmlspecialchars($question) . '</label>';
                            echo '<input type="text" class="form-control" id="change_answer' . ($index + 1) . '" name="answers[]" required>';
                            echo '</div>';
                        }
                        ?>
                        <div class="form-group">
                            <label for="new_password">Nueva Contraseña:</label>
                            <input type="password" class="form-control" id="new_password" name="new_password" required>
                        </div>
                        <button type="submit" class="btn btn-primary" name="change_password">Cambiar Contraseña</button>
                    </form>
                </div>


                <!-- jQuery and Bootstrap JS -->
                <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
                <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
                <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

                <script>
                    $(document).ready(function() {
                        $('#changePasswordBtn').click(function() {
                            $('#changePasswordModal').modal('show');
                        });
                    });
                </script>
</body>

</html>