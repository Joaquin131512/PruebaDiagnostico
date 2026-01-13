# Sistema de Registro de Productos

## 📋 Descripción

Sistema web interactivo para el registro de productos en una base de datos PostgreSQL. Permite crear productos con múltiples atributos como bodega, sucursal, moneda, precio, materiales y descripción. Validaciones en tiempo real mediante JavaScript y AJAX.

---

## 🔧 Requisitos del Sistema

- **PHP** 7.4 o superior (se recomienda PHP 8.0+)
- **PostgreSQL** 12 o superior (se recomienda PostgreSQL 16)
- **Servidor Web** Apache (o compatible con PHP)
- **Extensión PostgreSQL** para PHP (`php-pgsql`)

---

## 🚀 Instrucciones de Instalación

### Paso 1: Descargar el Proyecto
Clona o descarga el proyecto en tu servidor web.

Ejemplo para XAMPP:
```
C:\xampp\htdocs\Prueba_tecnica\
```

### Paso 2: Verificar PostgreSQL
Asegúrate de que PostgreSQL esté instalado y ejecutándose:
- **Windows**: Verifica en Servicios que `postgresql-x64-XX` esté activo
- **Linux/Mac**: Usa `sudo systemctl status postgresql`

### Paso 3: Crear la Base de Datos
Abre PowerShell, CMD o Terminal y ejecuta:

```bash
createdb -U postgres "Registro_Productos_Prueba"
```

Cuando pida contraseña, ingresa: `tempo001`
(O la que tengas configurada para el usuario postgres)

### Paso 4: Importar la Estructura de la BD
Ejecuta este comando para importar el archivo SQL:

```bash
psql -U postgres -d "Registro_Productos_Prueba" -f [RUTA_AL_ARCHIVO]\databbase.sql
```

**Ejemplo en Windows:**
```bash
psql -U postgres -d "Registro_Productos_Prueba" -f C:\xampp\htdocs\Prueba_tecnica\sql\databbase.sql
```

Cuando pida contraseña, ingresa: `tempo001`

### Paso 5: Verificar la Configuración
El archivo `config.php` ya contiene los parámetros de conexión:

```php
define('DB_HOST', 'localhost');
define('DB_PORT', '5432');
define('DB_NAME', 'Registro_Productos_Prueba');
define('DB_USER', 'postgres');
define('DB_PASS', 'tempo001');
```

**Si usas credenciales diferentes**, edita el archivo:
```
php/config.php
```

### Paso 6: Acceder a la Aplicación
Abre tu navegador web e ingresa:

```
http://localhost/Prueba_tecnica/
```

---

## 📁 Estructura de Archivos

```
Prueba_tecnica/
├── index.php                      # Página principal (formulario)
├── debug.php                      # Archivo de debug
├── debug_connection.php           # Test de conexión a BD
├── debug_sucursales.php           # Test de sucursales
├── README.md                      # Este archivo
├── README.txt                     # Instrucciones en texto plano
│
├── css/
│   └── style.css                  # Estilos CSS
│
├── js/
│   └── main.js                    # JavaScript/AJAX
│
├── php/
│   ├── config.php                 # Configuración de BD
│   ├── getBodega.php              # Obtener bodegas
│   ├── getSucursales.php          # Obtener sucursales
│   ├── getMonedas.php             # Obtener monedas
│   ├── getMateriales.php          # Obtener materiales
│   ├── guardarProducto.php        # Guardar producto
│   └── verificacionCodigo.php     # Verificar código único
│
└── sql/
    └── databbase.sql              # Script SQL (tablas + datos)
```

---

## 💻 Uso de la Aplicación

### Campos del Formulario

| Campo | Requisitos | Ejemplo |
|-------|-----------|---------|
| **Código** | 5-15 caracteres (letras y números) | `ABC123XYZ` |
| **Nombre** | 2-50 caracteres | `Mesa de Madera` |
| **Bodega** | Obligatorio (cargado dinámicamente) | Bodega Central |
| **Sucursal** | Obligatorio (se carga al seleccionar bodega) | Sucursal Central - Santiago |
| **Moneda** | Obligatorio | CLP, USD, EUR, ARS |
| **Precio** | Número positivo con hasta 2 decimales | `19.99`, `100` |
| **Material** | Mínimo 2 opciones | Metal, Madera |
| **Descripción** | 10-1000 caracteres | `Descripción del producto...` |

### Flujo de Uso

1. **Llenar el formulario** con todos los datos requeridos
2. **Seleccionar bodega** para cargar dinámicamente las sucursales
3. **Seleccionar sucursal** de las opciones cargadas
4. **Seleccionar mínimo 2 materiales** usando los checkboxes
5. **Haz clic en "Guardar Producto"**
6. **Verifica el resultado** - se mostrará un mensaje de éxito o error

### Validaciones

✅ Todas las validaciones se realizan en **JavaScript en tiempo real**
✅ Los errores se muestran en **alertas** descriptivas
✅ El código se verifica en la **base de datos** para asegurar unicidad
✅ Se valida **formato, longitud y obligatoriedad** de cada campo

---

## 🐛 Solución de Problemas

### ❌ "Error de conexión a la base de datos"

**Soluciones:**
1. Verifica que PostgreSQL esté corriendo
   ```bash
   # En Windows
   tasklist | findstr postgres
   ```
2. Comprueba que la base de datos exista
   ```bash
   psql -U postgres -l | findstr "Registro"
   ```
3. Verifica las credenciales en `php/config.php`

---

### ❌ "La página muestra 'Seleccione una bodega' sin opciones"

**Soluciones:**
1. Abre: `http://localhost/Prueba_tecnica/debug_connection.php`
2. Verifica que la conexión sea exitosa
3. Si no, recrea la BD siguiendo **Paso 3 y 4** de instalación

---

### ❌ "No se pueden guardar productos"

**Soluciones:**
1. Abre la consola del navegador: **F12** → pestaña **Console**
2. Revisa los mensajes de error
3. Verifica que:
   - ✅ Todos los campos estén completos
   - ✅ El código sea único (no repetido)
   - ✅ El código tenga 5-15 caracteres
   - ✅ Se seleccionen mínimo 2 materiales

---

## 📊 Tabla de Base de Datos

### Tablas creadas:
- `bodegas` - Almacenes principales
- `sucursales` - Sucursales por bodega
- `monedas` - Monedas disponibles
- `materiales` - Tipos de materiales
- `productos` - Productos registrados
- `producto_materiales` - Relación muchos a muchos

**Datos de prueba incluidos:**
- 4 Bodegas
- 8 Sucursales
- 4 Monedas
- 8 Materiales

---

## ℹ️ Información de Versión

| Elemento | Versión |
|----------|---------|
| **PHP** | 7.4+ (recomendado 8.0+) |
| **PostgreSQL** | 12+ (desarrollado con 16) |
| **HTML** | 5 |
| **JavaScript** | ES6+ |
| **Última actualización** | Enero 2026 |

---

## 📞 Soporte y Debugging

Si encuentras problemas, verifica:

1. **PostgreSQL corriendo:**
   ```bash
   psql -U postgres -c "SELECT version();"
   ```

2. **Base de datos creada:**
   ```bash
   psql -U postgres -l | findstr "Registro_Productos_Prueba"
   ```

3. **Verificar conexión:**
   - Abre: `http://localhost/Prueba_tecnica/debug_connection.php`

4. **Logs de PHP:**
   - Windows: `C:\xampp\apache\logs\error.log`
   - Linux: `/var/log/apache2/error.log`

5. **Consola del navegador:**
   - Presiona **F12** y revisa la pestaña **Console**

---

## ✨ Características

- ✅ Validación de formularios con JavaScript (sin frameworks)
- ✅ Carga dinámica de datos desde la BD
- ✅ Comunicación AJAX con PHP
- ✅ Verificación de código único en BD
- ✅ Relaciones muchos a muchos (productos-materiales)
- ✅ Interfaz responsive
- ✅ Estilos CSS nativos (sin frameworks)
- ✅ Mensajes de error personalizados

---

## 📄 Licencia

Este proyecto fue desarrollado como prueba técnica.

---

**¡Listo para usar!** 🎉
