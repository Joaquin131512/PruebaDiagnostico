CREATE TABLE IF NOT EXISTS bodegas (
    id_bodega SERIAL PRIMARY KEY,
    nombre_bodega VARCHAR(100) NOT NULL,
    estado BOOLEAN DEFAULT TRUE
);

-- Tabla de Sucursales
CREATE TABLE IF NOT EXISTS sucursales (
    id_sucursal SERIAL PRIMARY KEY,
    id_bodega INTEGER NOT NULL,
    nombre_sucursal VARCHAR(100) NOT NULL,
    estado BOOLEAN DEFAULT TRUE,
    FOREIGN KEY (id_bodega) REFERENCES bodegas(id_bodega) ON DELETE CASCADE
);

-- Tabla de Monedas
CREATE TABLE IF NOT EXISTS monedas (
    id_moneda SERIAL PRIMARY KEY,
    codigo_moneda VARCHAR(10) NOT NULL UNIQUE,
    nombre_moneda VARCHAR(50) NOT NULL,
    simbolo VARCHAR(5),
    estado BOOLEAN DEFAULT TRUE
);

-- Tabla de Materiales
CREATE TABLE IF NOT EXISTS materiales (
    id_material SERIAL PRIMARY KEY,
    nombre_material VARCHAR(50) NOT NULL,
    estado BOOLEAN DEFAULT TRUE
);

-- Tabla de Productos
CREATE TABLE IF NOT EXISTS productos (
    id_producto SERIAL PRIMARY KEY,
    codigo_producto VARCHAR(15) NOT NULL UNIQUE,
    nombre_producto VARCHAR(50) NOT NULL,
    id_bodega INTEGER NOT NULL,
    id_sucursal INTEGER NOT NULL,
    id_moneda INTEGER NOT NULL,
    precio DECIMAL(10,2) NOT NULL,
    descripcion TEXT NOT NULL,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_bodega) REFERENCES bodegas(id_bodega),
    FOREIGN KEY (id_sucursal) REFERENCES sucursales(id_sucursal),
    FOREIGN KEY (id_moneda) REFERENCES monedas(id_moneda)
);

-- Tabla intermedia para productos y materiales (relación muchos a muchos)
CREATE TABLE IF NOT EXISTS producto_materiales (
    id_producto_material SERIAL PRIMARY KEY,
    id_producto INTEGER NOT NULL,
    id_material INTEGER NOT NULL,
    FOREIGN KEY (id_producto) REFERENCES productos(id_producto) ON DELETE CASCADE,
    FOREIGN KEY (id_material) REFERENCES materiales(id_material) ON DELETE CASCADE,
    UNIQUE(id_producto, id_material)
);

-- Insertar datos de prueba en Bodegas
INSERT INTO bodegas (nombre_bodega) VALUES
('Bodega Central'),
('Bodega Norte'),
('Bodega Sur'),
('Bodega Este');

-- Insertar datos de prueba en Sucursales
INSERT INTO sucursales (id_bodega, nombre_sucursal) VALUES
(1, 'Sucursal Central - Santiago'),
(1, 'Sucursal Central - Viña del Mar'),
(2, 'Sucursal Norte - Antofagasta'),
(2, 'Sucursal Norte - Iquique'),
(3, 'Sucursal Sur - Concepción'),
(3, 'Sucursal Sur - Temuco'),
(4, 'Sucursal Este - Mendoza'),
(4, 'Sucursal Este - Córdoba');

-- Insertar datos de prueba en Monedas
INSERT INTO monedas (codigo_moneda, nombre_moneda, simbolo) VALUES
('CLP', 'Peso Chileno', '$'),
('USD', 'Dólar Estadounidense', 'US$'),
('EUR', 'Euro', '€'),
('ARS', 'Peso Argentino', '$');

-- Insertar datos de prueba en Materiales
INSERT INTO materiales (nombre_material) VALUES
('Plástico'),
('Metal'),
('Madera'),
('Vidrio'),
('Tela'),
('Cuero'),
('Cartón'),
('Cerámica');

-- Crear índices para mejorar el rendimiento
CREATE INDEX idx_producto_codigo ON productos(codigo_producto);
CREATE INDEX idx_sucursal_bodega ON sucursales(id_bodega);
CREATE INDEX idx_producto_bodega ON productos(id_bodega);
CREATE INDEX idx_producto_materiales_producto ON producto_materiales(id_producto);

-- Comentarios en las tablas
COMMENT ON TABLE productos IS 'Tabla principal de productos registrados';
COMMENT ON TABLE producto_materiales IS 'Relación muchos a muchos entre productos y materiales';
COMMENT ON COLUMN productos.codigo_producto IS 'Código único del producto (5-15 caracteres alfanuméricos)';
COMMENT ON COLUMN productos.precio IS 'Precio del producto con hasta 2 decimales';