
let productsList = [];


function loadClients() {
    apiFetch('clients').then(data => {
          let select = document.getElementById('client_id');

          select.innerHTML = '';

          let genericId = null;

          // select.innerHTML = '<option value="">Seleccionar cliente</option>';

          data.forEach(client => {
               if(client.name.toLowerCase()==='genérico nacional'){
                    genericId = client.id;
               }

               let option =`
                    <option value="${client.id}">
                         ${client.name}
                    </option>
               `;
               select.innerHTML += option;
          });

          if(genericId){
               select.value = genericId;
          }
    });
}

async function loadUsers() {
    let users = await apiFetch('users');
    // console.log("USERR",users);
    
    let select = document.getElementById("user_id");
    select.innerHTML = '';

    users.forEach(user => {
        let option = document.createElement("option");
        option.value = user.id;
        option.textContent = user.name;
        select.appendChild(option);
    });
}

// async function loadUser(){
//      let data = await apiFetch('me');
//      let select = document.getElementById('user_id');
//      select.value = data.id;
// }

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

async function loadProducts(){
     productsList = await apiFetch('products');
}

function calcularRow(row){
    // console.log("ROW", row)
     let qty = parseFloat(row.querySelector('.qty').value) || 0;
     let price = parseFloat(row.querySelector('.price').value) || 0;
     let discount = parseFloat(row.querySelector('.discount').value) || 0;
     let taxRate = parseFloat(row.querySelector('.tax-rate')?.value);
     

     let subtotal = qty * price;

     let discountAmount = subtotal * (discount / 100);

     let base = subtotal - discountAmount;

     let iva = base * taxRate;

     let total = base + iva;

     row.querySelector('.total').value = total.toFixed(2);
}

function addNewRow(){
    let table = document.getElementById('products-table');
    let index = table.rows.length + 1;
    // console.log("INDEX",index);
    

    let row = `
        <tr>
            <td>${index}</td>
            <td style="position:relative;">
                <input type="text" class="form-control search-product" placeholder="Buscar">
                <div class="dropdown-products"></div>
            </td>
            <td><input type="text" class="form-control desc"></td>
            <td><input type="number" class="form-control qty" value="1"></td>
            <td><input type="number" class="form-control price" value="0.00"></td>
            <td><input type="number" class="form-control discount" value="0"></td>
            <td><select class="form-control tax-rate"><option value="0">Sin IVA</option><option value="0.16">IVA %16</option><option value="0.18">IVA %18</option></select></td>
            <td><input type="number" class="form-control total" value="0.00" readonly></td>
            <td><button class="btn btn-danger btn-sm delete-row"><i class="bi bi-trash"></i></button></td>
        </tr>
    `;

    table.insertAdjacentHTML('beforeend', row);
}

document.addEventListener('click', function(e){
    if(e.target.classList.contains('item-product')){
        let productId = e.target.dataset.id;
        let product = productsList.find(p => p.id == productId);

        let row = e.target.closest('tr');

        row.querySelector('.search-product').value = product.name;
        row.querySelector('.desc').value = product.description || '';
        row.querySelector('.price').value = product.price || 0;
        row.dataset.productId = product.id;

        calcularRow(row);

        e.target.parentElement.innerHTML = '';

        addNewRow(); 
    }

    if(e.target.classList.contains('delete-row')){
          e.target.closest('tr').remove();
    }
});

document.addEventListener('input', function(e){
    if(e.target.classList.contains('search-product')){
        let query = e.target.value.toLowerCase();
        let container = e.target.nextElementSibling;

        if(!query){
            container.innerHTML = '';
            return;
        }

        let results = productsList.filter(p =>
            p.name.toLowerCase().includes(query)
        );

        let html = '';
        results.forEach(product => {
            html += `
                <div class="item-product" data-id="${product.id}">
                    ${product.name}
                </div>
            `;
        });

        container.innerHTML = html;
    }

    if(
        e.target.classList.contains('qty') ||
        e.target.classList.contains('price') ||
        e.target.classList.contains('discount') ||
        e.target.classList.contains('tax-rate') 
    ){
        let row = e.target.closest('tr');
        calcularRow(row);
    }
});



document.addEventListener('DOMContentLoaded', async ()=> {
     loadClients();
    //  await loadUser();
     await loadUsers();
     await loadProducts();
     // generateFolio();
})