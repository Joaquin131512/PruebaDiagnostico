================================================================================
SISTEMA DE REGISTRO DE PRODUCTOS
================================================================================

DESCRIPCIÓN:
Sistema web para el registro de productos en una base de datos PostgreSQL.
Permite crear productos con múltiples atributos como bodega, sucursal, moneda,
precio, materiales y descripción.

================================================================================
REQUISITOS DEL SISTEMA
================================================================================

- PHP 7.4 o superior (se recomienda PHP 8.0+)
- PostgreSQL 12 o superior (se recomienda PostgreSQL 16)
- Servidor Web Apache (o compatible con PHP)
- Extensión PostgreSQL para PHP (php-pgsql)

================================================================================
INSTRUCCIONES DE INSTALACIÓN
================================================================================

PASO 1: DESCARGAR EL PROYECTO
- Clonar o descargar el proyecto en tu servidor web
- Por ejemplo: C:\xampp\htdocs\Prueba_tecnica\

PASO 2: VERIFICAR POSTGRESQL
- Asegúrate de que PostgreSQL esté instalado y ejecutándose
- En Windows: Verificar en Servicios que "postgresql-x64-XX" esté activo

PASO 3: CREAR LA BASE DE DATOS
Abre PowerShell o CMD y ejecuta este comando para crear la base de datos:

  createdb -U postgres "Registro_Productos_Prueba"

Cuando pida contraseña, ingresa: tempo001
(O la contraseña que tengas configurada para el usuario postgres)

PASO 4: IMPORTAR LA ESTRUCTURA Y DATOS DE LA BD
Ejecuta este comando para importar el archivo SQL:

  psql -U postgres -d "Registro_Productos_Prueba" -f [RUTA_AL_ARCHIVO]\databbase.sql

Ejemplo en Windows:
  psql -U postgres -d "Registro_Productos_Prueba" -f C:\xampp\htdocs\Prueba_tecnica\sql\databbase.sql

Cuando pida contraseña, ingresa: tempo001

PASO 5: VERIFICAR LA CONEXIÓN
El archivo config.php ya contiene los parámetros de conexión:
- Host: localhost
- Puerto: 5432
- Usuario: postgres
- Contraseña: tempo001
- Base de datos: Registro_Productos_Prueba

Si usas credenciales diferentes, edita el archivo:
  php/config.php

PASO 6: ACCEDER A LA APLICACIÓN
Abre tu navegador web e ingresa:

  http://localhost/Prueba_tecnica/

O si está en otra ubicación, ajusta la URL según corresponda.

================================================================================
ESTRUCTURA DE ARCHIVOS
================================================================================

Prueba_tecnica/
├── index.php                    # Página principal (formulario)
├── README.txt                   # Este archivo
├── css/
│   └── style.css               # Estilos CSS de la aplicación
├── js/
│   └── main.js                 # JavaScript/AJAX de la aplicación
├── php/
│   ├── config.php              # Configuración de la BD
│   ├── getBodega.php           # Obtener bodegas
│   ├── getSucursales.php       # Obtener sucursales por bodega
│   ├── getMonedas.php          # Obtener monedas
│   ├── getMateriales.php       # Obtener materiales
│   ├── guardarProducto.php     # Guardar producto en la BD
│   └── verificacionCodigo.php  # Verificar código único
└── sql/
    └── databbase.sql           # Script SQL para crear tablas e insertar datos

================================================================================
USO DE LA APLICACIÓN
================================================================================

1. LLENAR EL FORMULARIO:
   - Código del Producto: 5-15 caracteres (letras y números)
   - Nombre del Producto: 2-50 caracteres
   - Bodega: Seleccionar de la lista (cargada dinámicamente)
   - Sucursal: Se carga automáticamente al seleccionar bodega
   - Moneda: Seleccionar de la lista (CLP, USD, EUR, ARS)
   - Precio: Número positivo con hasta 2 decimales
   - Material: Seleccionar mínimo 2 materiales
   - Descripción: 10-1000 caracteres

2. VALIDACIONES:
   - Todas las validaciones se realizan en JavaScript
   - Los errores se muestran en alertas
   - El código se verifica contra la base de datos para asegurar unicidad

3. GUARDAR:
   - Haz clic en "Guardar Producto"
   - Si todos los datos son válidos, se guardará en la BD
   - Se mostrará un mensaje de éxito o error

================================================================================
SOLUCIÓN DE PROBLEMAS
================================================================================

PROBLEMA: "Error de conexión a la base de datos"
SOLUCIÓN:
1. Verifica que PostgreSQL esté corriendo
2. Verifica que la base de datos "Registro_Productos_Prueba" exista
3. Verifica la contraseña en php/config.php

PROBLEMA: "La página muestra "Seleccione una bodega" sin opciones"
SOLUCIÓN:
1. Abre http://localhost/Prueba_tecnica/debug_connection.php
2. Verifica que la conexión sea exitosa
3. Si no, recrea la BD siguiendo los pasos de instalación

PROBLEMA: "No se pueden guardar productos"
SOLUCIÓN:
1. Abre la consola del navegador (F12)
2. Revisa los errores mostrados
3. Verifica que todos los campos estén completos
4. Asegúrate de seleccionar mínimo 2 materiales

================================================================================
INFORMACIÓN DE VERSIÓN
================================================================================

Versión de PHP: 7.4 o superior
Versión de PostgreSQL: 12 o superior (se desarrolló con 16)
Última actualización: Enero 2026

================================================================================
SOPORTE
================================================================================

Si tienes problemas, verifica:
1. Que PostgreSQL esté corriendo
2. Que la BD esté creada e importada
3. Los logs de error de PHP en: C:\xampp\apache\logs\
4. La consola del navegador (F12) para errores de JavaScript

================================================================================
