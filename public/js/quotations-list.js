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

document.addEventListener('DOMContentLoaded', async ()=> {
     await loadQuotations();
})