<?php

// Datos de conexión a la base de datos
$host = '200.59.184.50';
$port = '5432';
$dbname = 'broadcast';
$user = 'postgres';
$password = '12345';

$dsn = "pgsql:host=$host;port=$port;dbname=$dbname;user=$user;password=$password";

try {
    // Conexión a la base de datos
    $pdo = new PDO($dsn);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Configurar el modo de errores
} catch (PDOException $e) {
    die("Error al conectar a la base de datos: " . $e->getMessage());
}
?>