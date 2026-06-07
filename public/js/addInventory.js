const formProvider = document.getElementById("save-inventory");

formProvider.addEventListener("submit", async function(e){
     e.preventDefault();

     let product_id = document.getElementById("product").value;
     let numero_serie = document.getElementById("numero_serie").value;
     let codigo_barras = document.getElementById("codigo_barras").value;
     let garantia = document.getElementById("garantia").value;
     let estatus = "disponible";


     let response = await apiFetch('add-product-inventory',{
          method: 'POST',
          body:JSON.stringify({
               product_id:product_id,
               numero_serie:numero_serie,
               codigo_barras:codigo_barras,
               garantia:garantia,
               estatus:estatus
          })
     });


     if(response){
          Swal.fire({
               icon:'success',
               title:'Producto agregado al inventario'
          })
     };

     if(response){
          Swal.fire({
               icon:'success',
               title:'Producto agregado al inventario'
          });
          
          setTimeout(()=>{
               window.location.reload();
          }, 1500);
     } else{
          Swal.fire({
               icon:'error',
               title:'Error al agregar el producto al inventario'
          });
     }
});