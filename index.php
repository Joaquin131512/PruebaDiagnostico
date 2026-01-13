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
        <h1>Formulario de Producto</h1>
        
        <form id="formProducto">
            <div class="form-row">
                <div class="form-group form-group-half">
                    <label for="codigo">Código</label>
                    <input type="text" id="codigo" name="codigo" maxlength="15" placeholder="">
                </div>
                <div class="form-group form-group-half">
                    <label for="nombre">Nombre</label>
                    <input type="text" id="nombre" name="nombre" maxlength="50" placeholder="">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group form-group-half">
                    <label for="bodega">Bodega</label>
                    <select id="bodega" name="bodega">
                        <option value=""></option>
                    </select>
                </div>
                <div class="form-group form-group-half">
                    <label for="sucursal">Sucursal</label>
                    <select id="sucursal" name="sucursal">
                        <option value=""></option>
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group form-group-half">
                    <label for="moneda">Moneda</label>
                    <select id="moneda" name="moneda">
                        <option value=""></option>
                    </select>
                </div>
                <div class="form-group form-group-half">
                    <label for="precio">Precio</label>
                    <input type="text" id="precio" name="precio" placeholder="">
                </div>
            </div>

            <div class="form-group">
                <label>Material del Producto</label>
                <div id="materialesContainer" class="checkbox-group">
                    <!-- Los checkboxes se cargarán dinámicamente -->
                </div>
            </div>

            <div class="form-group">
                <label for="descripcion">Descripción</label>
                <textarea id="descripcion" name="descripcion" rows="5" maxlength="1000"></textarea>
            </div>

            <div class="form-group button-group">
                <button type="submit" id="btnGuardar">Guardar Producto</button>
            </div>
        </form>
    </div>

    <script src="js/main.js"></script>
</body>
</html>