/**
 * Products.js
 * 
 * Script encargado de la vista de listado de productos.
 * Funciones:
 * 1. Cargar productos desde la API y renderizar la tabla con precios
 * 2. Abrir modal de edición al hacer click en "Info"
 * 3. Gestión dinámica de filas de precios (agregar/eliminar)
 * 4. Guardar cambios del producto y precios via PUT a la API
 */

// ─── Cargar productos en la tabla ─────────────────────────────────
apiFetch('products').then(data => {
    let tbody = document.querySelector('tbody');
    tbody.innerHTML = '';

    // Renderizar cada producto con sus precios en columnas separadas
    data.forEach(product => {
        let tipoPrecios = "";
        let precios = "";

        if (product.prices && product.prices.length) {
            product.prices.forEach(p => {
                tipoPrecios += `${p.tipo_precio}<br>`;
                precios += `$${p.precio}<br>`;
            });
        } else {
            tipoPrecios = 'Sin precio';
            precios = '-';
        }

        // Escapar comillas simples en JSON para evitar romper el atributo data-product
        let row = `
        <tr>
            <td>${product.modelo}</td>
            <td>${product.nombre}</td>
            <td>${tipoPrecios}</td>
            <td>${precios}</td>
            <td>
                <button class="btn btn-success btn-sm btn-edit-product" data-product='${JSON.stringify(product).replace(/'/g, "&#39;")}'>Info</button>
            </td>
        </tr>
        `;
        tbody.innerHTML += row;
    });

    // Asignar event listeners a botones "Info"
    document.querySelectorAll('.btn-edit-product').forEach(btn => {
        btn.addEventListener('click', function() {
            const product = JSON.parse(this.getAttribute('data-product'));
            openEditProductModal(product);
        });
    });
});

// ─── Abrir modal con datos del producto ───────────────────────────

/**
 * Llena los campos del modal con los datos del producto seleccionado,
 * incluyendo la carga dinámica de sus precios existentes.
 * 
 * @param {Object} product - Objeto del producto con relación prices[]
 */
function openEditProductModal(product) {
    document.getElementById('edit_product_id').value = product.id;
    document.getElementById('edit_product_modelo').value = product.modelo || '';
    document.getElementById('edit_product_nombre').value = product.nombre || '';
    document.getElementById('edit_product_unidad').value = product.unidad_medida_id || '';

    // Limpiar y cargar los precios existentes como filas editables
    const container = document.getElementById('edit_product_prices_container');
    container.innerHTML = '';

    if (product.prices && product.prices.length) {
        product.prices.forEach((price, index) => {
            addPriceRow(price.tipo_precio, price.precio);
        });
    } else {
        // Si no tiene precios, mostrar una fila vacía
        addPriceRow('', '');
    }

    let modal = new bootstrap.Modal(document.getElementById('modalEditProduct'));
    modal.show();
}

// ─── Gestión dinámica de filas de precios ─────────────────────────

/**
 * Agrega una fila de precio al contenedor del modal.
 * Cada fila tiene: input tipo precio, input valor, botón eliminar.
 * 
 * @param {string} type - Tipo de precio (ej: "Público", "Mayoreo")
 * @param {number|string} price - Valor del precio
 */
function addPriceRow(type, price) {
    const container = document.getElementById('edit_product_prices_container');

    const row = document.createElement('div');
    row.className = 'row mb-2 price-row';
    row.innerHTML = `
        <div class="col-md-5">
            <input type="text" class="form-control price-type" placeholder="Tipo de precio" value="${type || ''}">
        </div>
        <div class="col-md-5">
            <input type="number" class="form-control price-value" placeholder="Precio" step="0.01" value="${price || ''}">
        </div>
        <div class="col-md-2">
            <button type="button" class="btn btn-sm btn-outline-danger btn-remove-price">✕</button>
        </div>
    `;
    container.appendChild(row);

    // Event listener para el botón de eliminar esta fila
    row.querySelector('.btn-remove-price').addEventListener('click', function() {
        row.remove();
    });
}

/**
 * Botón "Agregar precio" - Agrega una nueva fila vacía de precio
 */
document.getElementById('btnAddPrice').addEventListener('click', function() {
    addPriceRow('', '');
});

// ─── Guardar cambios del producto ─────────────────────────────────

/**
 * Al hacer click en "Guardar Cambios":
 * 1. Recopila datos del formulario (modelo, nombre, unidad)
 * 2. Recorre las filas de precios y arma el array
 * 3. Envía PUT a /api/products/{id}
 * 4. Si es exitoso, cierra modal y recarga la tabla
 */
document.getElementById('btnSaveProduct').addEventListener('click', function() {
    const productId = document.getElementById('edit_product_id').value;

    // Recopilar precios del formulario dinámico
    const priceRows = document.querySelectorAll('#edit_product_prices_container .price-row');
    const prices = [];
    priceRows.forEach(row => {
        const type = row.querySelector('.price-type').value.trim();
        const price = row.querySelector('.price-value').value.trim();
        // Solo agregar si ambos campos tienen valor
        if (type && price) {
            prices.push({ type: type, price: parseFloat(price) });
        }
    });

    // Armar payload con datos del producto y precios
    const data = {
        modelo: document.getElementById('edit_product_modelo').value,
        nombre: document.getElementById('edit_product_nombre').value,
        unidad_medida_id: document.getElementById('edit_product_unidad').value,
        prices: prices
    };

    // Enviar petición PUT a la API
    apiFetch(`products/${productId}`, {
        method: 'PUT',
        body: JSON.stringify(data)
    }).then(response => {
        if (response.success) {
            alert('Producto actualizado correctamente');
            let modal = bootstrap.Modal.getInstance(document.getElementById('modalEditProduct'));
            modal.hide();
            location.reload();
        } else {
            alert('Error al actualizar: ' + (response.message || 'Intente de nuevo'));
        }
    }).catch(err => {
        alert('Error de conexión');
        console.error(err);
    });
});
