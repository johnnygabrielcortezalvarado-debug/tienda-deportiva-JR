/* ============================================================
   validaciones.js — SportStore: Tienda de Ropa Deportiva
   Validaciones frontend con JavaScript
   ============================================================ */

document.addEventListener('DOMContentLoaded', () => {

    /* ── Confirmación de eliminación ──────────────────────── */
    document.querySelectorAll('.confirmar-eliminar').forEach(btn => {
        btn.addEventListener('click', (e) => {
            const nombre = btn.dataset.nombre || 'este elemento';
            if (!confirm(`¿Estás seguro de que deseas eliminar "${nombre}"?\nEsta acción no se puede deshacer.`)) {
                e.preventDefault();
            }
        });
    });

    /* ── Validación formulario de CATEGORÍA ───────────────── */
    const formCategoria = document.getElementById('formCategoria');
    if (formCategoria) {
        formCategoria.addEventListener('submit', (e) => {
            let valido = true;

            const nombre = document.getElementById('nombre');
            const errNombre = document.getElementById('errNombre');

            if (!nombre.value.trim()) {
                mostrarError(nombre, errNombre, 'El nombre de la categoría es obligatorio.');
                valido = false;
            } else if (nombre.value.trim().length < 3) {
                mostrarError(nombre, errNombre, 'El nombre debe tener al menos 3 caracteres.');
                valido = false;
            } else if (nombre.value.trim().length > 100) {
                mostrarError(nombre, errNombre, 'El nombre no puede superar los 100 caracteres.');
                valido = false;
            } else {
                mostrarValido(nombre, errNombre);
            }

            if (!valido) e.preventDefault();
        });

        // Validación en tiempo real
        const nombre = document.getElementById('nombre');
        const errNombre = document.getElementById('errNombre');
        if (nombre) {
            nombre.addEventListener('input', () => {
                if (nombre.value.trim().length >= 3) {
                    mostrarValido(nombre, errNombre);
                } else {
                    limpiarEstado(nombre, errNombre);
                }
            });
        }
    }

    /* ── Validación formulario de PRODUCTO ────────────────── */
    const formProducto = document.getElementById('formProducto');
    if (formProducto) {
        formProducto.addEventListener('submit', (e) => {
            let valido = true;

            const nombre     = document.getElementById('nombre');
            const categoriaId= document.getElementById('categoria_id');
            const precio     = document.getElementById('precio');
            const stock      = document.getElementById('stock');
            const errNombre  = document.getElementById('errNombre');
            const errCat     = document.getElementById('errCategoria');
            const errPrecio  = document.getElementById('errPrecio');
            const errStock   = document.getElementById('errStock');

            // Nombre
            if (!nombre.value.trim()) {
                mostrarError(nombre, errNombre, 'El nombre del producto es obligatorio.');
                valido = false;
            } else if (nombre.value.trim().length < 3) {
                mostrarError(nombre, errNombre, 'El nombre debe tener al menos 3 caracteres.');
                valido = false;
            } else {
                mostrarValido(nombre, errNombre);
            }

            // Categoría
            if (!categoriaId.value) {
                mostrarError(categoriaId, errCat, 'Selecciona una categoría.');
                valido = false;
            } else {
                mostrarValido(categoriaId, errCat);
            }

            // Precio
            const precioVal = parseFloat(precio.value);
            if (!precio.value || isNaN(precioVal) || precioVal <= 0) {
                mostrarError(precio, errPrecio, 'El precio debe ser un número mayor a 0.');
                valido = false;
            } else {
                mostrarValido(precio, errPrecio);
            }

            // Stock
            const stockVal = parseInt(stock.value);
            if (stock.value === '' || isNaN(stockVal) || stockVal < 0) {
                mostrarError(stock, errStock, 'El stock debe ser un número igual o mayor a 0.');
                valido = false;
            } else {
                mostrarValido(stock, errStock);
            }

            if (!valido) e.preventDefault();
        });

        // Validación en tiempo real
        const campos = [
            { id: 'nombre',       err: 'errNombre',    check: v => v.trim().length >= 3 },
            { id: 'precio',       err: 'errPrecio',    check: v => parseFloat(v) > 0 },
            { id: 'stock',        err: 'errStock',     check: v => parseInt(v) >= 0 && v !== '' },
            { id: 'categoria_id', err: 'errCategoria', check: v => v !== '' },
        ];

        campos.forEach(({ id, err }) => {
            const field = document.getElementById(id);
            const errEl = document.getElementById(err);
            if (field && errEl) {
                field.addEventListener('input', () => limpiarEstado(field, errEl));
                field.addEventListener('change', () => limpiarEstado(field, errEl));
            }
        });
    }

    /* ── Helpers ───────────────────────────────────────────── */
    function mostrarError(field, errEl, msg) {
        field.classList.add('invalid');
        field.classList.remove('valid');
        if (errEl) errEl.textContent = msg;
    }

    function mostrarValido(field, errEl) {
        field.classList.remove('invalid');
        field.classList.add('valid');
        if (errEl) errEl.textContent = '';
    }

    function limpiarEstado(field, errEl) {
        field.classList.remove('invalid', 'valid');
        if (errEl) errEl.textContent = '';
    }

});
