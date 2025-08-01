<?php 
session_start();

if (!isset($_SESSION['usuario'])) {
    die("Acceso denegado.");
}
$serverName = "sdb-apptransportistas-maco.database.windows.net";
$database = "db-apptransportistas-maco";
$username = "ServiceAppTrans";
$password = "⁠nZ(#n41LJm)iLmJP";

$connectionInfo = array(
    "Database" => $database,
    "UID" => $username,
    "PWD" => $password,
    "TrustServerCertificate" => true
);

$conn = sqlsrv_connect($serverName, $connectionInfo);
if (!$conn) {
    die("Error de conexión: " . print_r(sqlsrv_errors(), true));
}

$tiket = $_POST['tiket'];
$accion = $_POST['accion'];

if ($accion === 'insertar') {
    $query = "EXEC SP_Insertar_Retencion @Tiket = ?";
    $params = array($tiket);
    echo "Retención aplicada correctamente.";
} elseif ($accion === 'actualizar') {
    $query = "EXEC SP_Actualizar_Despacho @Tiket = ?";
    $params = array($tiket);
    echo "Se sacó de la retención correctamente.";
} else {
    die("Acción no válida.");
}

$stmt = sqlsrv_query($conn, $query, $params);

if ($stmt === false) {
    die("Error al ejecutar SP: " . print_r(sqlsrv_errors(), true));
}

sqlsrv_close($conn);
?>
