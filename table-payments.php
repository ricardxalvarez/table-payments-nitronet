<?php
session_start();

// Verificar si el usuario no ha iniciado sesión
if (!isset($_SESSION['username'])) {
    // Redirigir a la página de inicio de sesión u otra página adecuada
    header("Location: index.php");
    exit; // Asegurar que el script se detenga después de redirigir
}
require_once('config_db.php');

$records_per_page = 10; // Número de registros por página
$payments = [];         // Inicializar $payments como un array vacío
$total_pages = 0;       // Inicializar $total_pages con valor 0 por defecto
$current_page = 1;      // Página actual, por defecto la primera página

$successMessage = '';
$errorMessage = '';

// Manejo de eliminación de registros si se envía por POST
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_id'])) {
    $delete_id = $_POST['delete_id'];
    try {
        $sql = "DELETE FROM payments WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['id' => $delete_id]);

        if ($stmt->rowCount() > 0) {
            $successMessage = 'Registro eliminado correctamente.';
        };
    } catch (PDOException $e) {
        $errorMessage = 'Error de base de datos: ' . $e->getMessage();
    }
}

// Consultar el número total de registros y calcular páginas
try {
    $countSql = "SELECT COUNT(*) FROM payments";
    $stmt = $pdo->query($countSql);
    $total_records = $stmt->fetchColumn();
    $total_pages = ceil($total_records / $records_per_page);
    $current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $offset = ($current_page - 1) * $records_per_page;
    $sql = "SELECT * FROM payments ORDER BY created_at DESC LIMIT $records_per_page OFFSET $offset";
    $stmt = $pdo->query($sql);
    $payments = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error al consultar la base de datos: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Pagos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/styles.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <h1 class="text-center mb-4">Registro de Pagos</h1>

        <!-- Mensajes de éxito y error -->
        <?php if ($successMessage) : ?>
            <div class="alert alert-success" role="alert">
                <?= htmlspecialchars($successMessage) ?>
            </div>
        <?php endif; ?>
        <?php if ($errorMessage) : ?>
            <div class="alert alert-danger" role="alert">
                <?= htmlspecialchars($errorMessage) ?>
            </div>
        <?php endif; ?>

        <input type="text" id="searchInput" class="form-control mb-3" placeholder="Buscar...">

        <div class="table-responsive">
            <table id="paymentsTable" class="table table-striped table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>Fecha de Creación</th>
                        <th>Tipo de Ticket</th>
                        <th>Cédula</th>
                        <th>Monto Mensaje</th>
                        <th>Monto</th>
                        <th>Cambio USD</th>
                        <th>Monto USD</th>
                        <th>Fecha de pago</th>
                        <th>Referencia</th>
                        <th>Teléfono</th>
                        <th>Dispositivo</th>
                        <th>Geolocalización</th>
                        <th>Nombre Zona</th>
                        <th>Cobrado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($payments as $payment) : ?>
                        <tr>
                            <td><?= htmlspecialchars($payment['created_at']) ?></td>
                            <td><?= htmlspecialchars($payment['ticket_type']) ?></td>
                            <td><?= htmlspecialchars($payment['id_card']) ?></td>
                            <td><?= htmlspecialchars($payment['amount_message']) ?></td>
                            <td><?= htmlspecialchars($payment['amount']) ?></td>
                            <td><?= htmlspecialchars($payment['usd_exchange']) ?></td>
                            <td><?= htmlspecialchars($payment['usd_amount']) ?></td>
                            <td><?= htmlspecialchars($payment['date']) ?></td>
                            <td><?= htmlspecialchars($payment['ref']) ?></td>
                            <td><?= htmlspecialchars($payment['phone']) ?></td>
                            <td><?= htmlspecialchars($payment['dispositivo']) ?></td>
                            <td><?= htmlspecialchars($payment['geolocalizacion']) ?></td>
                            <td><?= htmlspecialchars($payment['nombre_zona']) ?></td>
                            <td><?= $payment['charged'] ? 'Sí' : 'No' ?></td>
                            <td>
                                <form method="post" onsubmit="return confirm('¿Estás seguro de que quieres eliminar este pago?')">
                                    <input type="hidden" name="delete_id" value="<?= $payment['id'] ?>">
                                    <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                </form>
                                <button class="btn btn-primary btn-sm" onclick="showPaymentDetails(<?= htmlspecialchars(json_encode($payment), ENT_QUOTES, 'UTF-8') ?>)">Detalles</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <a href="logout.php" class="btn btn-danger">Cerrar Sesión</a>

        <!-- Paginación -->
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                <?php if ($current_page > 1) : ?>
                    <li class="page-item">
                        <a class="page-link" href="table-payments.php?page=<?= ($current_page - 1) ?>" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                            <span class="visually-hidden">Anterior</span>
                        </a>
                    </li>
                <?php endif; ?>

                <?php for ($page = 1; $page <= $total_pages; $page++) : ?>
                    <li class="page-item <?= ($page == $current_page) ? 'active' : '' ?>">
                        <a class="page-link" href="table-payments.php?page=<?= $page ?>"><?= $page ?></a>
                    </li>
                <?php endfor; ?>

                <?php if ($current_page < $total_pages) : ?>
                    <li class="page-item">
                        <a class="page-link" href="table-payments.php?page=<?= ($current_page + 1) ?>" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                            <span class="visually-hidden">Siguiente</span>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>

    </div>

    <!-- Modal de Bootstrap para detalles -->
    <div class="modal fade" id="paymentDetailsModal" tabindex="-1" aria-labelledby="paymentDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="paymentDetailsModalLabel">Detalles del Pago</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Contenido dinámico de detalles aquí -->
                    <table class="table">
                        <tbody id="paymentDetailsBody">
                            <!-- Aquí se llenarán dinámicamente los detalles -->
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/script.js"></script>
</body>

</html>