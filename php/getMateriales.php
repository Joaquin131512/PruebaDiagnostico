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
    $query = "SELECT id_material, nombre_material 
              FROM materiales 
              WHERE estado = true 
              ORDER BY nombre_material";
    
    $result = pg_query($conn, $query);
    
    if (!$result) {
        throw new Exception(pg_last_error($conn));
    }
    
    $materiales = [];
    while ($row = pg_fetch_assoc($result)) {
        $materiales[] = $row;
    }
    
    echo json_encode([
        'success' => true,
        'message' => 'Materiales obtenidos correctamente',
        'data' => $materiales
    ]);
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error al obtener los materiales: ' . $e->getMessage(),
        'data' => null
    ]);
} finally {
    closeConnection($conn);
}
?>