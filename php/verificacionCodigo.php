<?php
header('Content-Type: application/json; charset=utf-8');
error_reporting(E_ERROR | E_PARSE);
require_once 'config.php';

if (!isset($_GET['codigo']) || empty($_GET['codigo'])) {
    sendJsonResponse(false, 'Código de producto no proporcionado');
}

$codigo = sanitizeInput($_GET['codigo']);

$conn = getConnection();

if (!$conn) {
    sendJsonResponse(false, 'Error de conexión a la base de datos');
}

try {
    $query = "SELECT COUNT(*) as total FROM productos WHERE codigo_producto = $1";
    $result = pg_query_params($conn, $query, array($codigo));
    
    if (!$result) {
        throw new Exception(pg_last_error($conn));
    }
    
    $row = pg_fetch_assoc($result);
    $existe = $row['total'] > 0;
    
    sendJsonResponse(true, $existe ? 'El código ya existe' : 'Código disponible', ['existe' => $existe]);
    
} catch (Exception $e) {
    sendJsonResponse(false, 'Error al verificar el código: ' . $e->getMessage());
} finally {
    closeConnection($conn);
}
?>