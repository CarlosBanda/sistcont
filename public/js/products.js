apiFetch('products').then(data => {
     let tbody = document.querySelector('tbody');
     tbody.innerHTML = '';

     data.forEach(product => {
           console.log("data ", product);
           let row = `
           <tr>
               <td>${product.category}</td>
               <td>${product.name}</td>
               <td>${product.code}</td>
               <td>${product.price}</td>
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

    let contenido = `
        <p><strong>Nombre:</strong> ${product.name}</p>
        <p><strong>Descripción:</strong> ${product.description}</p>
        <p><strong>Código de barra:</strong> ${product.barcode}</p>
        <p><strong>Clave SAT:</strong> ${product.sat_key}</p>
        <p><strong>Unidad de medidas SAT:</strong> ${product.sat_unit}</p>
    `;

    modalBody.innerHTML = contenido;

    let modal = new bootstrap.Modal(document.getElementById('modalProducto'));
    modal.show();
}