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
    $query = "SELECT id_moneda, codigo_moneda, nombre_moneda, simbolo 
              FROM monedas 
              WHERE estado = true 
              ORDER BY codigo_moneda";
    
    $result = pg_query($conn, $query);
    
    if (!$result) {
        throw new Exception(pg_last_error($conn));
    }
    
    $monedas = [];
    while ($row = pg_fetch_assoc($result)) {
        $monedas[] = $row;
    }
    
    echo json_encode([
        'success' => true,
        'message' => 'Monedas obtenidas correctamente',
        'data' => $monedas
    ]);
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error al obtener las monedas: ' . $e->getMessage(),
        'data' => null
    ]);
} finally {
    closeConnection($conn);
}
?>