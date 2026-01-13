<?php
/**
 * Configuración de conexión a PostgreSQL
 * Sistema de Registro de Productos
 */

// Configuración de la base de datos
define('DB_HOST', 'localhost');
define('DB_PORT', '5432');
define('DB_NAME', 'Registro_Productos_Prueba');
define('DB_USER', 'postgres');
define('DB_PASS', 'Ouroboros'); // Cambia esto por tu contraseña 

// Configuración de la aplicación
define('CHARSET', 'UTF8');

// Función para obtener la conexión
function getConnection() {
    // Suprimir warnings de PHP
    error_reporting(E_ERROR | E_PARSE);
    
    try {
        $connectionString = sprintf(
            "host=%s port=%s dbname=%s user=%s password=%s",
            DB_HOST,
            DB_PORT,
            DB_NAME,
            DB_USER,
            DB_PASS
        );
        
        $conn = @pg_connect($connectionString);
        
        if (!$conn) {
            throw new Exception("Error al conectar con la base de datos. Verifica las credenciales.");
        }
        
        // Establecer el charset
        pg_set_client_encoding($conn, CHARSET);
        
        return $conn;
        
    } catch (Exception $e) {
        error_log("Error de conexión: " . $e->getMessage());
        return false;
    }
}

// Función para cerrar la conexión
function closeConnection($conn) {
    if ($conn) {
        pg_close($conn);
    }
}

// Función para sanitizar datos
function sanitizeInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Función para enviar respuesta JSON
function sendJsonResponse($success, $message, $data = null) {
    header('Content-Type: application/json');
    echo json_encode([
        'success' => $success,
        'message' => $message,
        'data' => $data
    ]);
    exit;
}
?>