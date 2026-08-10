/**
 * addClients.js
 * 
 * Script para el formulario de crear clientes.
 * Maneja la lógica de mostrar/ocultar campos según el tipo de persona:
 * - Persona Física: muestra campos Nombres y Apellidos
 * - Persona Moral: muestra campo Razón Social / Nombre de Empresa
 */

const formClients = document.getElementById("save-client");
const typePerson = document.getElementById("type_person");
const camposFisica = document.getElementById("campos-fisica");
const camposMoral = document.getElementById("campos-moral");

// ─── Cambio dinámico de campos según tipo de persona ──────────────
typePerson.addEventListener("change", function() {
    if (this.value === "moral") {
        // Persona Moral: ocultar nombre/apellido, mostrar razón social
        camposFisica.style.display = "none";
        camposMoral.style.display = "flex";
        // Limpiar campos de persona física
        document.getElementById("name_input").value = "";
        document.getElementById("lastname_input").value = "";
    } else {
        // Persona Física u Otro: mostrar nombre/apellido, ocultar razón social
        camposFisica.style.display = "flex";
        camposMoral.style.display = "none";
        // Limpiar campo de persona moral
        document.getElementById("razon_social_input").value = "";
    }
});

// ─── Envío del formulario ─────────────────────────────────────────
formClients.addEventListener("submit", async function(e) {
    e.preventDefault();

    const tipo = typePerson.value;

    // Construir el nombre según el tipo de persona
    let name = "";
    let lastname = "";

    if (tipo === "moral") {
        // Para persona moral, usar razón social como nombre
        name = document.getElementById("razon_social_input").value.trim();
        if (!name) {
            Swal.fire({ icon: 'warning', title: 'Campo requerido', text: 'La Razón Social es obligatoria.' });
            return;
        }
    } else {
        // Para persona física, usar nombre + apellido
        name = document.getElementById("name_input").value.trim();
        lastname = document.getElementById("lastname_input").value.trim();
        if (!name) {
            Swal.fire({ icon: 'warning', title: 'Campo requerido', text: 'El nombre es obligatorio.' });
            return;
        }
    }

    // Validar RFC
    const rfc = document.getElementById("rfc_input_field").value.trim();
    if (!rfc) {
        Swal.fire({ icon: 'warning', title: 'Campo requerido', text: 'El RFC es obligatorio.' });
        return;
    }

    // Validar código postal
    const zipCode = document.getElementById("cp_input").value.trim();
    if (!zipCode) {
        Swal.fire({ icon: 'warning', title: 'Campo requerido', text: 'El código postal es obligatorio.' });
        return;
    }

    // Validar colonia
    const colony = document.getElementById("colonia_input").value.trim();
    if (!colony) {
        Swal.fire({ icon: 'warning', title: 'Campo requerido', text: 'La colonia es obligatoria.' });
        return;
    }

    // Armar payload
    const data = {
        name: name,
        lastname: lastname,
        rfc: rfc,
        email: document.getElementById("email_input").value.trim(),
        phone: document.getElementById("phone_input").value.trim(),
        zip_code: zipCode,
        colony: colony,
        city: document.getElementById("city_input").value.trim(),
        address: document.getElementById("address").value.trim(),
        country: document.getElementById("country_input").value.trim(),
        state: document.getElementById("state_input").value.trim(),
        number_ext: document.getElementById("number_ext_input").value.trim(),
        number_int: document.getElementById("number_int_input").value.trim(),
    };

    try {
        const response = await apiFetch("create-clients", {
            method: "POST",
            body: JSON.stringify(data)
        });

        if (response && response.client) {
            Swal.fire({
                icon: 'success',
                title: 'Cliente creado'
            });

            setTimeout(() => {
                formClients.reset();
                // Restaurar vista de persona física
                camposFisica.style.display = "flex";
                camposMoral.style.display = "none";
            }, 1500);
        } else {
            let errorMsg = 'Error al crear cliente';
            if (response && response.errors) {
                errorMsg = Object.values(response.errors).flat().join('\n');
            }
            Swal.fire({ icon: 'error', title: 'Error', text: errorMsg });
        }

    } catch (error) {
        console.error(error);
        Swal.fire({ icon: 'error', title: 'Error al crear Cliente' });
    }
});
