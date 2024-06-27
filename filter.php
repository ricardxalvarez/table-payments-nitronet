<?php
// Incluir el archivo de configuración de la base de datos
require_once 'config.php';

// Recibir los parámetros de filtro
$fechaInicio = $_GET['fechaInicio'];
$fechaFin = $_GET['fechaFin'];
$cedula = $_GET['cedula'];
$ref = $_GET['ref'];
$zona = $_GET['zona'];
$geolocalizacion = $_GET['geolocalizacion'];
$tipoTicket = $_GET['tipoTicket'];

// Consulta SQL base
$sql = "SELECT date, id_card, amount_message, amount, usd_exchange, usd_amount, ref, ticket_type, charged, phone, dispositivo, geolocalizacion, nombre_zona FROM payments WHERE 1";

// Agregar condiciones según los filtros ingresados
if (!empty($fechaInicio)) {
    $sql .= " AND date >= :fechaInicio";
}

if (!empty($fechaFin)) {
    $sql .= " AND date <= :fechaFin";
}

if (!empty($cedula)) {
    $sql .= " AND id_card = :cedula";
}

if (!empty($ref)) {
    $sql .= " AND ref = :ref";
}

if (!empty($zona)) {
    $sql .= " AND nombre_zona = :zona";
}

if (!empty($geolocalizacion)) {
    $sql .= " AND geolocalizacion = :geolocalizacion";
}

if (!empty($tipoTicket)) {
    $sql .= " AND ticket_type = :tipoTicket";
}

// Preparar la consulta SQL
$stmt = $pdo->prepare($sql);

// Asignar valores a los parámetros
if (!empty($fechaInicio)) {
    $stmt->bindParam(':fechaInicio', $fechaInicio);
}

if (!empty($fechaFin)) {
    $stmt->bindParam(':fechaFin', $fechaFin);
}

if (!empty($cedula)) {
    $stmt->bindParam(':cedula', $cedula);
}

if (!empty($ref)) {
    $stmt->bindParam(':ref', $ref);
}

if (!empty($zona)) {
    $stmt->bindParam(':zona', $zona);
}

if (!empty($geolocalizacion)) {
    $stmt->bindParam(':geolocalizacion', $geolocalizacion);
}

if (!empty($tipoTicket)) {
    $stmt->bindParam(':tipoTicket', $tipoTicket);
}

// Ejecutar la consulta
$stmt->execute();

// Generar el HTML de las filas de la tabla
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "<tr>";
    echo "<td>{$row['date']}</td>";
    echo "<td>{$row['id_card']}</td>";
    echo "<td>{$row['amount_message']}</td>";
    echo "<td>{$row['amount']}</td>";
    echo "<td>{$row['usd_exchange']}</td>";
    echo "<td>{$row['usd_amount']}</td>";
    echo "<td>{$row['ref']}</td>";
    echo "<td>{$row['ticket_type']}</td>";
    echo "<td>" . ($row['charged'] ? 'Sí' : 'No') . "</td>";
    echo "<td>{$row['phone']}</td>";
    echo "<td>{$row['dispositivo']}</td>";
    echo "<td>{$row['geolocalizacion']}</td>";
    echo "<td>{$row['nombre_zona']}</td>";
    echo "</tr>";
}
?>
