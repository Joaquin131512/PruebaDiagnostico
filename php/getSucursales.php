<?php
header('Content-Type: application/json; charset=utf-8');
error_reporting(E_ERROR | E_PARSE);
require_once 'config.php';

if (!isset($_GET['id_bodega']) || empty($_GET['id_bodega'])) {
    sendJsonResponse(false, 'ID de bodega no proporcionado');
}

$id_bodega = intval($_GET['id_bodega']);

$conn = getConnection();

if (!$conn) {
    sendJsonResponse(false, 'Error de conexión');
}

try {
    $query = "SELECT id_sucursal, nombre_sucursal 
              FROM sucursales 
              WHERE id_bodega = $1 AND estado = true 
              ORDER BY nombre_sucursal";
    
    $result = pg_query_params($conn, $query, array($id_bodega));
    
    if (!$result) {
        throw new Exception(pg_last_error($conn));
    }
    
    $sucursales = [];
    while ($row = pg_fetch_assoc($result)) {
        $sucursales[] = $row;
    }
    
    sendJsonResponse(true, 'Sucursales obtenidas correctamente', $sucursales);
    
} catch (Exception $e) {
    sendJsonResponse(false, 'Error al obtener las sucursales: ' . $e->getMessage());
} finally {
    closeConnection($conn);
}
?>