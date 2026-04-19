apiFetch('clients').then(data => {
     let tbody = document.querySelector('tbody');
     tbody.innerHTML = '';

     data.forEach(client => {
          //  console.log("data ", client);
           let row = `
           <tr>
               <td>${client.name}</td>
               <td>${client.address}</td>
               <td>${client.phone}</td>
               <td>${client.rfc}</td>
               <td>
                    <button id="${client.id}" type="button" class="btn btn-success">Info</button>
               </td>
               
           </tr>
           `;
            tbody.innerHTML += row;
     });
});
