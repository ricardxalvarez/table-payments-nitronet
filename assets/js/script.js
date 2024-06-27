function filterTable() {
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("searchInput");
    filter = input.value.toUpperCase();
    table = document.getElementById("paymentsTable");
    tr = table.getElementsByTagName("tr");

    for (i = 1; i < tr.length; i++) { // Empezar desde 1 para saltar el encabezado
        td = tr[i].getElementsByTagName("td");
        var rowContainsFilter = false;
        for (var j = 0; j < td.length; j++) {
            var cell = td[j];
            if (cell) {
                txtValue = cell.textContent || cell.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    rowContainsFilter = true;
                    break;
                }
            }
        }
        tr[i].style.display = rowContainsFilter ? "" : "none";
    }
}

document.getElementById("searchInput").addEventListener("keyup", function() {
    filterTable();
});

function showPaymentDetails(payment) {
    document.getElementById("paymentDetailsBody").innerHTML = "";

    var detailsHtml = "";
    for (var key in payment) {
        detailsHtml += "<tr><td><strong>" + traducirNombreCampo(key) + "</strong></td><td>" + formatValue(key, payment[key]) + "</td></tr>";
    }
    document.getElementById("paymentDetailsBody").innerHTML = detailsHtml;

    var myModal = new bootstrap.Modal(document.getElementById('paymentDetailsModal'), {
        keyboard: false
    });
    myModal.show();
}

function traducirNombreCampo(key) {
    switch (key) {
        case 'id': return 'ID';
        case 'created_at': return 'Fecha en la que se guardó el pago en la base de datos';
        case 'ticket_type': return 'Tipo de ticket que el usuario indica';
        case 'id_card': return 'Cédula que el usuario indica';
        case 'amount_message': return 'Cantidad que el usuario indica en el mensaje';
        case 'amount': return 'Cantidad que ha llegado al mensaje de pago móvil';
        case 'usd_exchange': return 'Tasa de cambio al momento del pago móvil';
        case 'usd_amount': return 'Cantidad en dólares en el mensaje de pago móvil';
        case 'date': return 'Fecha en la que se realizó el pago';
        case 'ref': return 'Número de referencia del pago';
        case 'phone': return 'Número de teléfono que el usuario indica en el SMS';
        case 'dispositivo': return 'Dispositivo que va a usar el usuario';
        case 'geolocalizacion': return 'Lugar donde el usuario usara el servicio';
        case 'nombre_zona': return 'Zona donde el usuario usara el servicio';
        case 'charged': return 'Cobrado';
        default: return key;
    }
}

function formatValue(key, value) {
    if (key === 'charged') {
        return value ? 'Sí' : 'No';
    }
    return value;
}

document.addEventListener('DOMContentLoaded', function () {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Limpiar mensajes al cargar la página
    var messageContainer = document.getElementById("messageContainer");
    messageContainer.innerHTML = '';
});

function deletePayment(id) {
    if (confirm("¿Estás seguro de que quieres eliminar este pago?")) {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "delete_payment.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                var messageContainer = document.getElementById("messageContainer");
                if (xhr.status === 200) {
                    messageContainer.innerHTML = '<div class="alert alert-success alert-dismissible fade show" role="alert">' +
                                                 'Pago eliminado correctamente.' +
                                                 '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
                                                 '</div>';
                    setTimeout(function() {
                        messageContainer.innerHTML = ''; // Eliminar el mensaje después de un tiempo
                        window.location.reload(); // Recargar la página después de un tiempo
                    }, 1500);
                } else {
                    messageContainer.innerHTML = '<div class="alert alert-danger alert-dismissible fade show" role="alert">' +
                                                 'Error al eliminar el pago.' +
                                                 '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
                                                 '</div>';
                    setTimeout(function() {
                        messageContainer.innerHTML = ''; // Eliminar el mensaje después de un tiempo
                    }, 1500);
                }
            }
        };
        xhr.send("id=" + encodeURIComponent(id));
    }
}
