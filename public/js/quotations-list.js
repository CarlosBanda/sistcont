let quotationList = [];

async function loadQuotations(){
     let data = await apiFetch('quotations');
     // console.log("DATA", data);
     
     quotationList = data;

     renderTable(data);
}

function renderTable(data){
     // console.log("data",data);
     
     let table = document.getElementById('quotations-table');
     table.innerHTML = '';

     data.forEach(q => {
        let row = `
          <tr>
               <td>${q.folio?.folio ?? ''}</td>
               <td>${q.client?.name ?? ''}</td>
               <td>${q.contact_name}</td>
               <td>${q.quotation_date}</td>
               <td>${q.currency}</td>
               <td>
                    <button class="btn btn-sm btn-info view-btn" data-id="${q.id}">
                         Ver
                    </button>
                    <button class="btn btn-sm btn-warning duplicate-btn" data-id="${q.id}">
                         Duplicar
                    </button>
                    <button class="btn btn-sm btn-success sale-btn"  data-id="${q.id}">
                         Venta
                    </button>
               </td>
          </tr>
        `;  
        table.innerHTML += row;
     });
}

document.getElementById('search-folio').addEventListener('input',function(){
     let value = this.value.toLowerCase();

     let filtered = quotationList.filter(q =>
          q.folio?.folio.toLowerCase().includes(value)
     );
     renderTable(filtered);
});

document.addEventListener('click', async function(e){

    // Duplicar
    if(e.target.classList.contains('duplicate-btn')){
        let id = e.target.dataset.id;

        let data = await apiFetch(`quotation/${id}`);

        localStorage.setItem('duplicateQuotation', JSON.stringify(data));

        window.location.href = '/crear-cotizacion'; 
    }

    // Convertir a venta
    if(e.target.classList.contains('sale-btn')){
        let id = e.target.dataset.id;

        let data = await apiFetch(`quotation/${id}`);
          // console.log("DATA",data);
          
        localStorage.setItem('quotationToSale', JSON.stringify(data));

        window.location.href = '/sales/create-sale';
    }

    // VER (opcional por ahora luego vemos si es editar o solo ver)
     const btn = e.target.closest('button');
     if(!btn) return;

     if(btn.classList.contains('view-btn')){
          
          let id = e.target.dataset.id;

          let data = await apiFetch(`quotation/${id}`);
               console.log("DATA", data);
               
          localStorage.setItem('viewQuotation', JSON.stringify(data));

          window.location.href = '/crear-cotizacion';
     }
});


document.addEventListener('DOMContentLoaded', async ()=> {
     if(document.getElementById('quotations-table')){
          await loadQuotations();
     }

});