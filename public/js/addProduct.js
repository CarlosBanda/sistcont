const form = document.getElementById("save-product");

form.addEventListener("submit", async function(e) {
     e.preventDefault();

     let product_category = document.getElementById("product_category").value;
     let product_code = document.getElementById("product_code").value;
     let product_name = document.getElementById("product_name").value;
     let product_price = document.getElementById("product_price").value;
     let product_bar = document.getElementById("product_bar").value;
     let product_description = document.getElementById("product_description").value;
     let product_sat = document.getElementById("product_sat").value;
     let product_unit = document.getElementById("product_unit").value;

     // console.log(product_category);
     let response = await apiFetch('create-products',{
          method: 'POST',
          body:JSON.stringify({
               product_category:product_category,
               product_code:product_code,
               product_name:product_name,
               product_price:product_price,
               product_bar:product_bar,
               product_description:product_description,
               product_sat:product_sat,
               product_unit:product_unit
          })
     });

     if(response){
          Swal.fire({
               icon:'success',
               title:'Producto creada'
          });
          
          setTimeout(()=>{
               window.location.reload();
          }, 1500);
     } else{
          Swal.fire({
               icon:'error',
               title:'Error al registrar'
          });
     }
     
     
})