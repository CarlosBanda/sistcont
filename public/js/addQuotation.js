const formQuotation = document.getElementById("save-quotation");

formQuotation.addEventListener("submit", async function(e){
     e.preventDefault();

     // let folio = document.getElementById("folio").value;
     let client_id = document.getElementById("client_id").value;
     let contact_name = document.getElementById("contact_name").value;
     let quotation_date = document.getElementById("quotation_date").value;
     let currency = document.getElementById("currency").value;
     let user_id = document.getElementById("user_id").value;
     let subtotal = document.getElementById("subtotal").value;
     let discount_total = document.getElementById("discount_total").value;
     let tax_total = document.getElementById("tax_total").value;
     let grand_total = document.getElementById("grand_total").value;

     let rows = document.querySelectorAll('#products-table tr');
     let products = [];

     if(!client_id || !contact_name || !quotation_date || !currency || !user_id){
          Swal.fire({
               icon: 'warning',
               title: 'Campos incompletos',
               text: 'Por favor llena todos los campos'
          });
          return;
     }

     rows.forEach(row => {
          let productId = row.dataset.productId;

          if(!productId) return;

          let qty = row.querySelector('.qty').value;
          let barcode = row.querySelector('.barcode').value;
          let price = row.querySelector('.price').value;
          let discount = row.querySelector('.discount').value;
          let tax = row.querySelector('.tax-rate').value;
          let total = row.querySelector('.total').value;

          products.push({
               product_id: productId,
               qty: qty,
               barcode: barcode,
               price: price,
               discount: discount,
               tax: tax,
               total: total
          });
     });

     if(products.length === 0){
          Swal.fire({
               icon: 'warning',
               title: 'Sin productos',
               text: 'Agregar al menos un producto a la cotización'
          });   
          return;
     }

     for (let p of products) {
          if(!p.qty || p.qty <= 0 || !p.price || p.price <= 0){
               Swal.fire({
                    icon: 'warning',
                    title: 'Datos inválidos',
                    text: 'Revisa cantidad y precio de los productos'
               });
               return;
          }
     }

     let response = await apiFetch('create-quotation',{
          method: 'POST',
          body:JSON.stringify({
               user_id:user_id,
               client_id:client_id,
               contact_name:contact_name,
               quotation_date:quotation_date,
               currency:currency,
               subtotal:subtotal,
               discount_total:discount_total,
               tax_total:tax_total,
               grand_total:grand_total,
               products: products
          })
     });
     console.log("RESPONSE",response);
     

     if(response){
          quotationId = response.quotation.id;
          Swal.fire({
               icon:'success',
               title:'Cotización creada'
          });
          document.getElementById('btn-pdf').style.display = 'block';

          // setTimeout(()=>{
          //      window.location.reload();
          // }, 1500);
     } else{
          Swal.fire({
               icon:'error',
               title:'Error al crear Cotización'
          });
     }
});