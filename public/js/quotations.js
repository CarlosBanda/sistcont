

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

function loadFolio(){
     apiFetch('next-folio').then(data => {
          let input = document.getElementById('folio');
          input.value = data.folio;  
     });
}

document.addEventListener('DOMContentLoaded', ()=> {
     loadClients();
     loadUser();
     loadFolio();
})