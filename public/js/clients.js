/**
 * Clients.js
 * 
 * Script encargado de la vista de listado de clientes.
 * Funciones:
 * 1. Cargar clientes desde la API y renderizar la tabla
 * 2. Abrir modal de edición al hacer click en "Info"
 * 3. Guardar cambios del cliente via PUT a la API
 */

// ─── Cargar clientes en la tabla ──────────────────────────────────
apiFetch('clients').then(data => {
    let tbody = document.querySelector('tbody');
    tbody.innerHTML = '';

    // Renderizar cada cliente como una fila de la tabla
    data.forEach(client => {
        let row = `
        <tr>
            <td>${client.name}</td>
            <td>${client.address || '-'}</td>
            <td>${client.phone || '-'}</td>
            <td>${client.rfc}</td>
            <td>
                <button type="button" class="btn btn-success btn-sm btn-edit-client" data-client='${JSON.stringify(client)}'>Info</button>
            </td>
        </tr>
        `;
        tbody.innerHTML += row;
    });

    // Asignar event listener a cada botón "Info" para abrir el modal
    document.querySelectorAll('.btn-edit-client').forEach(btn => {
        btn.addEventListener('click', function() {
            const client = JSON.parse(this.getAttribute('data-client'));
            openEditClientModal(client);
        });
    });
});

// ─── Abrir modal con datos del cliente pre-llenados ───────────────

/**
 * Llena los campos del modal con los datos del cliente seleccionado
 * y muestra el modal de Bootstrap.
 * 
 * @param {Object} client - Objeto del cliente con todos sus campos
 */
function openEditClientModal(client) {
    document.getElementById('edit_client_id').value = client.id;
    document.getElementById('edit_client_name').value = client.name || '';
    document.getElementById('edit_client_rfc').value = client.rfc || '';
    document.getElementById('edit_client_email').value = client.email || '';
    document.getElementById('edit_client_phone').value = client.phone || '';
    document.getElementById('edit_client_zip_code').value = client.zip_code || '';
    document.getElementById('edit_client_colony').value = client.colony || '';
    document.getElementById('edit_client_address').value = client.address || '';
    document.getElementById('edit_client_number_ext').value = client.number_ext || '';
    document.getElementById('edit_client_number_int').value = client.number_int || '';
    document.getElementById('edit_client_city').value = client.city || '';
    document.getElementById('edit_client_state').value = client.state || '';
    document.getElementById('edit_client_country').value = client.country || '';

    let modal = new bootstrap.Modal(document.getElementById('modalEditClient'));
    modal.show();
}

// ─── Guardar cambios del cliente ──────────────────────────────────

/**
 * Al hacer click en "Guardar Cambios", recopila los datos del formulario
 * y envía un PUT a /api/clients/{id}.
 * Si la respuesta es exitosa, cierra el modal y recarga la página.
 */
document.getElementById('btnSaveClient').addEventListener('click', function() {
    const clientId = document.getElementById('edit_client_id').value;

    // Recopilar todos los campos del formulario
    const data = {
        name: document.getElementById('edit_client_name').value,
        rfc: document.getElementById('edit_client_rfc').value,
        email: document.getElementById('edit_client_email').value,
        phone: document.getElementById('edit_client_phone').value,
        zip_code: document.getElementById('edit_client_zip_code').value,
        colony: document.getElementById('edit_client_colony').value,
        address: document.getElementById('edit_client_address').value,
        number_ext: document.getElementById('edit_client_number_ext').value,
        number_int: document.getElementById('edit_client_number_int').value,
        city: document.getElementById('edit_client_city').value,
        state: document.getElementById('edit_client_state').value,
        country: document.getElementById('edit_client_country').value,
    };

    // Enviar petición PUT a la API
    apiFetch(`clients/${clientId}`, {
        method: 'PUT',
        body: JSON.stringify(data)
    }).then(response => {
        if (response.success) {
            alert('Cliente actualizado correctamente');
            // Cerrar modal y recargar para ver los cambios
            let modal = bootstrap.Modal.getInstance(document.getElementById('modalEditClient'));
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
