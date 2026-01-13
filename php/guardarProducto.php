<?php
header('Content-Type: application/json; charset=utf-8');
error_reporting(E_ERROR | E_PARSE);
require_once 'config.php';

// Verificar que sea una petición POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    sendJsonResponse(false, 'Método no permitido');
}

// Obtener datos del POST
$codigo = isset($_POST['codigo']) ? sanitizeInput($_POST['codigo']) : '';
$nombre = isset($_POST['nombre']) ? sanitizeInput($_POST['nombre']) : '';
$bodega = isset($_POST['bodega']) ? intval($_POST['bodega']) : 0;
$sucursal = isset($_POST['sucursal']) ? intval($_POST['sucursal']) : 0;
$moneda = isset($_POST['moneda']) ? intval($_POST['moneda']) : 0;
$precio = isset($_POST['precio']) ? $_POST['precio'] : '';
$descripcion = isset($_POST['descripcion']) ? sanitizeInput($_POST['descripcion']) : '';
$materiales = isset($_POST['materiales']) ? $_POST['materiales'] : [];

// Validaciones básicas en el servidor
if (empty($codigo) || empty($nombre) || $bodega == 0 || $sucursal == 0 || 
    $moneda == 0 || empty($precio) || empty($descripcion) || count($materiales) < 2) {
    sendJsonResponse(false, 'Todos los campos son obligatorios');
}

$conn = getConnection();

if (!$conn) {
    sendJsonResponse(false, 'Error de conexión a la base de datos');
}

// Iniciar transacción
pg_query($conn, "BEGIN");

try {
    // Verificar que el código no exista
    $queryVerificar = "SELECT COUNT(*) as total FROM productos WHERE codigo_producto = $1";
    $resultVerificar = pg_query_params($conn, $queryVerificar, array($codigo));
    $rowVerificar = pg_fetch_assoc($resultVerificar);
    
    if ($rowVerificar['total'] > 0) {
        throw new Exception('El código del producto ya está registrado');
    }
    
    // Insertar el producto
    $queryProducto = "INSERT INTO productos 
                      (codigo_producto, nombre_producto, id_bodega, id_sucursal, id_moneda, precio, descripcion) 
                      VALUES ($1, $2, $3, $4, $5, $6, $7) 
                      RETURNING id_producto";
    
    $resultProducto = pg_query_params($conn, $queryProducto, array(
        $codigo,
        $nombre,
        $bodega,
        $sucursal,
        $moneda,
        $precio,
        $descripcion
    ));
    
    if (!$resultProducto) {
        throw new Exception(pg_last_error($conn));
    }
    
    $rowProducto = pg_fetch_assoc($resultProducto);
    $idProducto = $rowProducto['id_producto'];
    
    // Insertar los materiales del producto
    foreach ($materiales as $idMaterial) {
        $queryMaterial = "INSERT INTO producto_materiales (id_producto, id_material) VALUES ($1, $2)";
        $resultMaterial = pg_query_params($conn, $queryMaterial, array($idProducto, intval($idMaterial)));
        
        if (!$resultMaterial) {
            throw new Exception(pg_last_error($conn));
        }
    }
    
    // Confirmar transacción
    pg_query($conn, "COMMIT");
    
    sendJsonResponse(true, 'Producto guardado exitosamente', ['id_producto' => $idProducto]);
    
} catch (Exception $e) {
    // Revertir transacción en caso de error
    pg_query($conn, "ROLLBACK");
    sendJsonResponse(false, 'Error al guardar el producto: ' . $e->getMessage());
} finally {
    closeConnection($conn);
}
?> 