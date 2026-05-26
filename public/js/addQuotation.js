const formQuotation = document.getElementById("save-quotation");

formQuotation.addEventListener("submit", async function(e){
     e.preventDefault();

     // let folio = document.getElementById("folio").value;
     let client_id = document.getElementById("client_id").value;
     let contact_name = document.getElementById("contact_name").value;
     let quotation_date = document.getElementById("quotation_date").value;
     let currency = document.getElementById("currency").value;
     let user_id = document.getElementById("user_id").value;

     let rows = document.querySelectorAll('#products-table tr');
     let products = [];

     rows.forEach(row => {
          let productId = row.dataset.productId;

          if(!productId) return;

          let qty = row.querySelector('.qty').value;
          let price = row.querySelector('.price').value;
          let discount = row.querySelector('.discount').value;
          let tax = row.querySelector('.tax-rate').value;
          let total = row.querySelector('.total').value;

          products.push({
               product_id: productId,
               qty: qty,
               price: price,
               discount: discount,
               tax: tax,
               total: total
          });
     });

     let response = await apiFetch('create-quotation',{
          method: 'POST',
          body:JSON.stringify({
               user_id:user_id,
               client_id:client_id,
               contact_name:contact_name,
               quotation_date:quotation_date,
               currency:currency,
               products: products
          })
     });
     console.log("RESPONSE",response);
     

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