

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

function loadUser(){
     apiFetch('me').then(data => {
          let input = document.getElementById('user_name');
          input.value = data.name;
          
     });
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


document.addEventListener('DOMContentLoaded', ()=> {
     loadClients();
     loadUser();
     // generateFolio();
})