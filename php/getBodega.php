<?php
header('Content-Type: application/json; charset=utf-8');
error_reporting(E_ERROR | E_PARSE);
require_once 'config.php';

$conn = getConnection();

if (!$conn) {
    echo json_encode([
        'success' => false,
        'message' => 'Error de conexión a la base de datos',
        'data' => null
    ]);
    exit;
}

try {
    $query = "SELECT id_bodega, nombre_bodega FROM bodegas WHERE estado = true ORDER BY nombre_bodega";
    $result = pg_query($conn, $query);
    
    if (!$result) {
        throw new Exception(pg_last_error($conn));
    }
    
    $bodegas = [];
    while ($row = pg_fetch_assoc($result)) {
        $bodegas[] = $row;
    }
    
    echo json_encode([
        'success' => true,
        'message' => 'Bodegas obtenidas correctamente',
        'data' => $bodegas
    ]);
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error al obtener las bodegas: ' . $e->getMessage(),
        'data' => null
    ]);
} finally {
    closeConnection($conn);
}
?>