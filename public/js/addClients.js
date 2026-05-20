const formClients = document.getElementById("save-client");

formClients.addEventListener("submit", async function(e){

    e.preventDefault();

    const form = this;
    const formData = new FormData(form);
    const data  = Object.fromEntries(formData.entries());

    console.log("data",data);

    // validar campos vacíos
    for (let [name, value] of formData.entries()) {

        if (!value.trim()) {
            alert("El campo " + name + " está vacío");
            return;
        }

    }

    try {

        const response = await apiFetch("create-clients", {
            method: "POST",
            body: JSON.stringify(data) 
        });

     //    const data = await response.json();

     //    console.log(data);

          Swal.fire({
               icon:'success',
               title:'Cliente creada'
          });
          
          setTimeout(()=>{
               form.reset();
          }, 1500);

    } catch (error) {

        console.error(error);
          Swal.fire({
               icon:'error',
               title:'Error al crear Cliente'
          });

    }

});
