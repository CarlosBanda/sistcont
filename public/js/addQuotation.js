const formQuotation = document.getElementById("save-quotation");

formQuotation.addEventListener("submit", async function(e){
     e.preventDefault();
     let serie = document.getElementById("serie").value;
     let folio = document.getElementById("folio").value;
     let client_id = document.getElementById("client_id").value;
     let contact_name = document.getElementById("contact_name").value;
     let quotation_date = document.getElementById("quotation_date").value;
     let currency = document.getElementById("currency").value;

     let response = await apiFetch('create-quotation',{
          method: 'POST',
          body:JSON.stringify({
               serie:serie,
               folio:folio,
               client_id:client_id,
               contact_name:contact_name,
               quotation_date:quotation_date,
               currency:currency
          })
     });

     if(response){
          Swal.fire({
               icon:'success',
               title:'Cotización creada'
          });
          
          setTimeout(()=>{
               window.location.reload();
          }, 1500);
     } else{
          Swal.fire({
               icon:'error',
               title:'Error al crear Cotización'
          });
     }
});