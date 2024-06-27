<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Tablas y Datos en PostgreSQL</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h2 class="mb-4">Crear Tablas y Datos en PostgreSQL</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <button type="submit" class="btn btn-primary" name="create_tables">Crear Tablas y Datos</button>
        </form>
        <hr>
        <div class="mt-4">
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["create_tables"])) {
                // Datos de conexión a la base de datos
                $host = '200.59.184.50';
                $port = '5432';
                $dbname = 'broadcast';
                $user = 'postgres';
                $password = '12345';

                try {
                    // Conexión a la base de datos
                    $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$dbname;user=$user;password=$password");
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    // Consultas SQL para crear tablas
                    $create_questions_table = "
                        CREATE TABLE IF NOT EXISTS questions (
                            id SERIAL PRIMARY KEY,
                            question_text VARCHAR(255) NOT NULL,
                            answer_text VARCHAR(255) NOT NULL
                        )
                    ";

                    // Preguntas y respuestas en español
                    $questions = [
                        ["¿Cuál es tu color favorito?", "azul"],
                        ["¿Cuál es el nombre de tu primera mascota?", "luna"],
                        ["¿Dónde nació tu madre?", "ciudad a"],
                        ["¿Cuál es tu película favorita?", "titanic"],
                        ["¿Cuál es tu comida favorita?", "pizza"]
                    ];

                    // Crear tabla de preguntas si no existe
                    $pdo->exec($create_questions_table);
                    echo "<p>Tabla de preguntas creada correctamente.</p>";

                    // Insertar preguntas si la tabla está vacía
                    $stmt = $pdo->query("SELECT COUNT(*) FROM questions");
                    $count = $stmt->fetchColumn();

                    if ($count == 0) {
                        $insert_question = $pdo->prepare("INSERT INTO questions (question_text, answer_text) VALUES (?, ?)");
                        foreach ($questions as $question) {
                            $insert_question->execute([$question[0], $question[1]]);
                        }
                        echo "<p>Preguntas insertadas correctamente en la tabla 'questions'.</p>";
                    }

                    // Tabla de usuarios (solo username y password)
                    $create_users_table = "
                        CREATE TABLE IF NOT EXISTS users (
                            id SERIAL PRIMARY KEY,
                            username VARCHAR(100) NOT NULL UNIQUE,
                            password VARCHAR(255) NOT NULL
                        )
                    ";

                    // Crear tabla de usuarios si no existe
                    $pdo->exec($create_users_table);
                    echo "<p>Tabla de usuarios creada correctamente.</p>";

                    // Insertar usuario de ejemplo si la tabla está vacía
                    $stmt = $pdo->query("SELECT COUNT(*) FROM users");
                    $count_users = $stmt->fetchColumn();

                    if ($count_users == 0) {
                        $username = "Admin-nitronet";
                        $password = "Nitronet_pagos.85047373";

                        // Hashear la contraseña
                        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                        // Insertar usuario y contraseña hasheada
                        $insert_user = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
                        $insert_user->execute([$username, $hashedPassword]);
                        echo "<p>Usuario insertado correctamente en la tabla 'users'.</p>";
                    }
                } catch (PDOException $e) {
                    die("Error al conectar a la base de datos: " . $e->getMessage());
                } finally {
                    // Cerrar la conexión
                    $pdo = null;
                }
            }
            ?>
        </div>
    </div>
</body>

</html>