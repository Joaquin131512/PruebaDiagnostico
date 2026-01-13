// Variables globales
let materiales = [];

// Expresiones regulares
const regexCodigo = /^(?=.*[a-zA-Z])(?=.*\d)[a-zA-Z\d]+$/;
const regexPrecio = /^\d+(\.\d{1,2})?$/;

// Inicialización cuando el DOM está listo
document.addEventListener('DOMContentLoaded', function() {
    cargarBodegas();
    cargarMonedas();
    cargarMateriales();
    
    document.getElementById('bodega').addEventListener('change', cargarSucursales);
    document.getElementById('formProducto').addEventListener('submit', guardarProducto);
});

// Función para cargar bodegas
function cargarBodegas() {
    fetch('php/getBodega.php')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const select = document.getElementById('bodega');
                data.data.forEach(bodega => {
                    const option = document.createElement('option');
                    option.value = bodega.id_bodega;
                    option.textContent = bodega.nombre_bodega;
                    select.appendChild(option);
                });
            }
        })
        .catch(error => {
            console.error('Error al cargar bodegas:', error);
            alert('Error al cargar las bodegas');
        });
}

// Función para cargar sucursales según bodega seleccionada
function cargarSucursales() {
    const bodegaId = document.getElementById('bodega').value;
    const selectSucursal = document.getElementById('sucursal');
    
    // Limpiar sucursales y resetear a opción en blanco
    selectSucursal.innerHTML = '<option value=""></option>';
    
    if (!bodegaId) {
        return;
    }
    
    fetch(`php/getSucursales.php?id_bodega=${bodegaId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Mantener la opción en blanco al inicio
                selectSucursal.innerHTML = '<option value=""></option>';
                data.data.forEach(sucursal => {
                    const option = document.createElement('option');
                    option.value = sucursal.id_sucursal;
                    option.textContent = sucursal.nombre_sucursal;
                    selectSucursal.appendChild(option);
                });
            }
        })
        .catch(error => {
            console.error('Error al cargar sucursales:', error);
            alert('Error al cargar las sucursales');
        });
}

// Función para cargar monedas
function cargarMonedas() {
    fetch('php/getMonedas.php')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const select = document.getElementById('moneda');
                data.data.forEach(moneda => {
                    const option = document.createElement('option');
                    option.value = moneda.id_moneda;
                    option.textContent = `${moneda.codigo_moneda} - ${moneda.nombre_moneda}`;
                    select.appendChild(option);
                });
            }
        })
        .catch(error => {
            console.error('Error al cargar monedas:', error);
            alert('Error al cargar las monedas');
        });
}

// Función para cargar materiales
function cargarMateriales() {
    fetch('php/getMateriales.php')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                materiales = data.data;
                const container = document.getElementById('materialesContainer');
                
                data.data.forEach(material => {
                    const div = document.createElement('div');
                    div.className = 'checkbox-item';
                    
                    const checkbox = document.createElement('input');
                    checkbox.type = 'checkbox';
                    checkbox.id = `material_${material.id_material}`;
                    checkbox.name = 'materiales[]';
                    checkbox.value = material.id_material;
                    
                    const label = document.createElement('label');
                    label.htmlFor = `material_${material.id_material}`;
                    label.textContent = material.nombre_material;
                    
                    div.appendChild(checkbox);
                    div.appendChild(label);
                    container.appendChild(div);
                });
            }
        })
        .catch(error => {
            console.error('Error al cargar materiales:', error);
            alert('Error al cargar los materiales');
        });
}

// Validación del código del producto
function validarCodigo() {
    const codigo = document.getElementById('codigo').value.trim();
    
    // Validar campo vacío
    if (codigo === '') {
        alert('El código del producto no puede estar en blanco.');
        return false;
    }
    
    // Validar longitud
    if (codigo.length < 5 || codigo.length > 15) {
        alert('El código del producto debe tener entre 5 y 15 caracteres.');
        return false;
    }
    
    // Validar formato (letras y números)
    if (!regexCodigo.test(codigo)) {
        alert('El código del producto debe contener letras y números');
        return false;
    }
    
    return true;
}

// Validar nombre del producto
function validarNombre() {
    const nombre = document.getElementById('nombre').value.trim();
    
    if (nombre === '') {
        alert('El nombre del producto no puede estar en blanco.');
        return false;
    }
    
    if (nombre.length < 2 || nombre.length > 50) {
        alert('El nombre del producto debe tener entre 2 y 50 caracteres.');
        return false;
    }
    
    return true;
}

// Validar bodega
function validarBodega() {
    const bodega = document.getElementById('bodega').value;
    
    if (bodega === '') {
        alert('Debe seleccionar una bodega.');
        return false;
    }
    
    return true;
}

// Validar sucursal
function validarSucursal() {
    const sucursal = document.getElementById('sucursal').value;
    
    if (sucursal === '') {
        alert('Debe seleccionar una sucursal para la bodega seleccionada.');
        return false;
    }
    
    return true;
}

// Validar moneda
function validarMoneda() {
    const moneda = document.getElementById('moneda').value;
    
    if (moneda === '') {
        alert('Debe seleccionar una moneda para el producto.');
        return false;
    }
    
    return true;
}

// Validar precio
function validarPrecio() {
    const precio = document.getElementById('precio').value.trim();
    
    if (precio === '') {
        alert('El precio del producto no puede estar en blanco.');
        return false;
    }
    
    if (!regexPrecio.test(precio) || parseFloat(precio) <= 0) {
        alert('El precio del producto debe ser un número positivo con hasta dos decimales.');
        return false;
    }
    
    return true;
}

// Validar materiales
function validarMateriales() {
    const checkboxes = document.querySelectorAll('input[name="materiales[]"]:checked');
    
    if (checkboxes.length < 2) {
        alert('Debe seleccionar al menos dos materiales para el producto.');
        return false;
    }
    
    return true;
}

// Validar descripción
function validarDescripcion() {
    const descripcion = document.getElementById('descripcion').value.trim();
    
    if (descripcion === '') {
        alert('La descripción del producto no puede estar en blanco.');
        return false;
    }
    
    if (descripcion.length < 10 || descripcion.length > 1000) {
        alert('La descripción del producto debe tener entre 10 y 1000 caracteres.');
        return false;
    }
    
    return true;
}

// Verificar si el código ya existe en la base de datos
function verificarCodigoUnico(codigo) {
    return fetch(`php/verificacionCodigo.php?codigo=${encodeURIComponent(codigo)}`)
        .then(response => response.json())
        .then(data => {
            if (data.success && data.data.existe) {
                alert('El código del producto ya está registrado.');
                return false;
            }
            return true;
        })
        .catch(error => {
            console.error('Error al verificar código:', error);
            alert('Error al verificar el código del producto');
            return false;
        });
}

// Función principal para guardar producto
async function guardarProducto(e) {
    e.preventDefault();
    
    // Validar todos los campos
    if (!validarCodigo()) return;
    if (!validarNombre()) return;
    if (!validarBodega()) return;
    if (!validarSucursal()) return;
    if (!validarMoneda()) return;
    if (!validarPrecio()) return;
    if (!validarMateriales()) return;
    if (!validarDescripcion()) return;
    
    // Verificar que el código sea único
    const codigo = document.getElementById('codigo').value.trim();
    const esUnico = await verificarCodigoUnico(codigo);
    
    if (!esUnico) return;
    
    // Deshabilitar el botón mientras se procesa
    const btnGuardar = document.getElementById('btnGuardar');
    btnGuardar.disabled = true;
    btnGuardar.textContent = 'Guardando...';
    
    // Preparar los datos del formulario
    const formData = new FormData();
    formData.append('codigo', document.getElementById('codigo').value.trim());
    formData.append('nombre', document.getElementById('nombre').value.trim());
    formData.append('bodega', document.getElementById('bodega').value);
    formData.append('sucursal', document.getElementById('sucursal').value);
    formData.append('moneda', document.getElementById('moneda').value);
    formData.append('precio', document.getElementById('precio').value.trim());
    formData.append('descripcion', document.getElementById('descripcion').value.trim());
    
    // Agregar materiales seleccionados
    const checkboxes = document.querySelectorAll('input[name="materiales[]"]:checked');
    checkboxes.forEach((checkbox, index) => {
        formData.append(`materiales[${index}]`, checkbox.value);
    });
    
    // Enviar datos mediante AJAX
    fetch('php/guardarProducto.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Producto guardado exitosamente');
            document.getElementById('formProducto').reset();
            document.getElementById('sucursal').innerHTML = '<option value="">Seleccione una sucursal</option>';
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al guardar el producto');
    })
    .finally(() => {
        btnGuardar.disabled = false;
        btnGuardar.textContent = 'Guardar Producto';
    });
}