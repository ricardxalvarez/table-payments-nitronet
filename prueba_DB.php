<?php

$host = '200.59.184.50';
$port = '5432';
$dbname = 'broadcast';
$user = 'postgres';
$password = '12345';

try {
    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname;user=$user;password=$password";
    $db = new PDO($dsn);
    echo "Conectado a la base de datos PostgreSQL remota";
} catch (PDOException $e) {
    echo "Error al conectar a la base de datos PostgreSQL remota: " . $e->getMessage();
}
