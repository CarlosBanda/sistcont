const form = document.getElementById("save-product");
let priceIndex = 0;

document.getElementById('add-price').addEventListener('click', function () {

    let container = document.getElementById('prices-container');

    let html = `
        <div class="price-item mb-2">
            <div class="row">
                <div class="col-md-5">
                    <input type="text" class="form-control price-type" placeholder="Mayoreo">
                </div>
                <div class="col-md-5">
                    <input type="number" class="form-control price-value" placeholder="Precio">
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger btn-sm remove-price">X</button>
                </div>
            </div>
        </div>
    `;

    container.insertAdjacentHTML('beforeend', html);
});


document.addEventListener('click', function(e){
    if(e.target.classList.contains('remove-price')){
        e.target.closest('.price-item').remove();
    }
});


form.addEventListener("submit", async function(e) {
     e.preventDefault();

     let product_model = document.getElementById("product_model").value;
     let product_name = document.getElementById("product_name").value;
     let product_unit = document.getElementById("product_unit").value;
     let prices = [];

    document.querySelectorAll('.price-item').forEach(item=>{
        let type = item.querySelector('.price-type').value;
        let value = item.querySelector('.price-value').value;

        if(type && value){
            prices.push({
                type:type,
                price: value
            });
        }
    });

    // console.log("PRICE", prices);

     let response = await apiFetch('create-products',{
          method: 'POST',
          body:JSON.stringify({
               product_model:product_model,
               product_name:product_name,
               product_unit:product_unit,
               prices:prices
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
     
     
});