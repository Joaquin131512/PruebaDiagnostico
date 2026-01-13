<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Registro de Productos</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1>Registro de Productos</h1>
        
        <form id="formProducto">
            <div class="form-group">
                <label for="codigo">Código del Producto:</label>
                <input type="text" id="codigo" name="codigo" maxlength="15">
            </div>

            <div class="form-group">
                <label for="nombre">Nombre del Producto:</label>
                <input type="text" id="nombre" name="nombre" maxlength="50">
            </div>

            <div class="form-group">
                <label for="bodega">Bodega:</label>
                <select id="bodega" name="bodega">
                    <option value="">Seleccione una bodega</option>
                </select>
            </div>

            <div class="form-group">
                <label for="sucursal">Sucursal:</label>
                <select id="sucursal" name="sucursal">
                    <option value="">Seleccione una sucursal</option>
                </select>
            </div>

            <div class="form-group">
                <label for="moneda">Moneda:</label>
                <select id="moneda" name="moneda">
                    <option value="">Seleccione una moneda</option>
                </select>
            </div>

            <div class="form-group">
                <label for="precio">Precio:</label>
                <input type="text" id="precio" name="precio">
            </div>

            <div class="form-group">
                <label>Material del Producto:</label>
                <div id="materialesContainer" class="checkbox-group">
                    <!-- Los checkboxes se cargarán dinámicamente -->
                </div>
            </div>

            <div class="form-group">
                <label for="descripcion">Descripción del Producto:</label>
                <textarea id="descripcion" name="descripcion" rows="5" maxlength="1000"></textarea>
            </div>

            <div class="form-group">
                <button type="submit" id="btnGuardar">Guardar Producto</button>
            </div>
        </form>
    </div>

    <script src="js/main.js"></script>
</body>
</html>