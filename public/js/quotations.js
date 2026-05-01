

function loadClients() {
     apiFetch('clients').then(data => {
          let select = document.getElementById('client_id');

          select.innerHTML = '<option value="">Seleccionar cliente</option>';

          data.forEach(client => {
               let option =`
                    <option value="${client.id}">
                         ${client.name}
                    </option>
               `;
               select.innerHTML += option;
          });
     });
}

async function loadUsers() {
    let users = await apiFetch('users');

    let select = document.getElementById("user_id");
    select.innerHTML = '';

    users.forEach(user => {
        let option = document.createElement("option");
        option.value = user.id;
        option.textContent = user.name;
        select.appendChild(option);
    });
}

async function loadUser(){
     let data = await apiFetch('me');
     let select = document.getElementById('user_id');
     select.value = data.id;
}

function generateFolio(type){
     apiFetch(`next-folio?type=${type}`)
     .then(data => {
          document.getElementById('folio').value = data.folio;
     })
     .catch(err => {
          console.error(err);
          Swal.fire({
               icon: "error",
               title: "Error al generar el folio"
          });
     });
}


document.addEventListener('DOMContentLoaded', async ()=> {
     loadClients();
     await loadUser();
     await loadUsers();
     // generateFolio();
})