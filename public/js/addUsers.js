const formUser = document.getElementById('save-user');

formUser.addEventListener("submit", async function(e){
     e.preventDefault();
     let nameUser = document.getElementById('name_user').value;
     let lastnameUser = document.getElementById('lastname_user').value;
     let emailUser = document.getElementById('email_user').value;
     let passwordUser = document.getElementById('password_user').value;

     let response = await apiFetch('create-users',{
          method: 'POST',
          body:JSON.stringify({
               nameUser: nameUser,
               lastnameUser:lastnameUser,
               emailUser:emailUser,
               passwordUser:passwordUser
          })
     });
     

     if(response){
          Swal.fire({
               icon:'success',
               title:'Usuario creada'
          });
          
          setTimeout(()=>{
               window.location.reload();
          }, 1500);
     } else{
          Swal.fire({
               icon:'error',
               title:'Error al crear el Usuario'
          });
     }
});