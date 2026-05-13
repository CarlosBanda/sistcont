const formProvider = document.getElementById("save-provider");

formProvider.addEventListener("submit", async function(e){
     e.preventDefault();

     // let folio = document.getElementById("folio").value;
     let name_comercial = document.getElementById("name_comercial").value;
     let razon_social = document.getElementById("razon_social").value;
     let cp = document.getElementById("cp").value;
     let colonia = document.getElementById("colonia").value;
     let rfc = document.getElementById("rfc").value;
     let municipio = document.getElementById("municipio").value;
     let address = document.getElementById("address").value;
     let pais = document.getElementById("pais").value;
     let ciudad = document.getElementById("ciudad").value;
     let num_ext = document.getElementById("num_ext").value;
     let status = document.getElementById("status").value;


     let response = await apiFetch('create-provider',{
          method: 'POST',
          body:JSON.stringify({
               rfc:rfc,
               name_comercial:name_comercial,
               razon_social:razon_social,
               cp:cp,
               colonia:colonia,
               municipio:municipio,
               address:address,
               pais:pais,
               ciudad:ciudad,
               num_ext:num_ext,
               status:status
          })
     });

     if(response){
          Swal.fire({
               icon:'success',
               title:'Proveedor creado'
          });
          
          setTimeout(()=>{
               window.location.reload();
          }, 1500);
     } else{
          Swal.fire({
               icon:'error',
               title:'Error al crear Proveedor'
          });
     }
});