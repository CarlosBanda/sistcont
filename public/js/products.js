apiFetch('products').then(data => {
     let tbody = document.querySelector('tbody');
     tbody.innerHTML = '';

     data.forEach(product => {
            // console.log("data ", product);
        
           let tipoPrecios ="";
           let precios ="";

           if(product.prices && product.prices.length){
                product.prices.forEach(p => {
                    tipoPrecios += `${p.tipo_precio}<br>`;
                    precios += `$${p.precio}<br>`;
                });
           } else{
            tipoPrecios = 'Sin preecio';
            precios = '-';
           }
        //    console.log("precios ", precios);
           let row = `
           <tr>
               <td>${product.modelo}</td>
               <td>${product.nombre}</td>
  
               <td >${tipoPrecios}</td>
               <td >${precios}</td>
               <td>
                    <button class="btn btn-info btn-sm" onclick='verProducto(${JSON.stringify(product)})'>Ver</button>
                    <button class="btn btn-warning btn-sm">Editar</button>
               </td>
               
           </tr>
           `;
            tbody.innerHTML += row;
     });
});

function verProducto(product){
    let modalBody = document.getElementById('modalBody');
    let tipoPrecios ="";
    let precios ="";

    product.prices.forEach(p => {
        tipoPrecios += `${p.tipo_precio}`;
        precios += `$${p.precio}`;
    });

    let contenido = `
        <p><strong>Modelo:</strong> ${product.modelo}</p>
        <p><strong>Nombre:</strong> ${product.nombre}</p>
        <p><strong>Unidad de medida:</strong> ${product.unidad_de_medida}</p>
        <p><strong>Tipo precio:</strong> ${tipoPrecios}</p>
        <p><strong>Precio:</strong> ${precios}</p>
    `;

    modalBody.innerHTML = contenido;

    let modal = new bootstrap.Modal(document.getElementById('modalProducto'));
    modal.show();
}