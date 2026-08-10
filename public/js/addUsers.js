const formUser = document.getElementById('save-user');

formUser.addEventListener("submit", async function(e){
     e.preventDefault();
     let nameUser = document.getElementById('name_user').value;
     let lastnameUser = document.getElementById('lastname_user').value;
     let emailUser = document.getElementById('email_user').value;
     let passwordUser = document.getElementById('password_user').value;

     // Validar contraseña
     if (passwordUser.length < 8) {
          Swal.fire({ icon: 'warning', title: 'Contraseña muy corta', text: 'La contraseña debe tener al menos 8 caracteres.' });
          return;
     }
     if (!/[A-Z]/.test(passwordUser)) {
          Swal.fire({ icon: 'warning', title: 'Contraseña insegura', text: 'Debe incluir al menos una letra mayúscula.' });
          return;
     }
     if (!/[a-z]/.test(passwordUser)) {
          Swal.fire({ icon: 'warning', title: 'Contraseña insegura', text: 'Debe incluir al menos una letra minúscula.' });
          return;
     }
     if (!/[0-9]/.test(passwordUser)) {
          Swal.fire({ icon: 'warning', title: 'Contraseña insegura', text: 'Debe incluir al menos un número.' });
          return;
     }
     if (!/[@$!%*?&#]/.test(passwordUser)) {
          Swal.fire({ icon: 'warning', title: 'Contraseña insegura', text: 'Debe incluir al menos un carácter especial (@$!%*?&#).' });
          return;
     }

     let response = await apiFetch('create-users',{
          method: 'POST',
          body:JSON.stringify({
               nameUser: nameUser,
               lastnameUser: lastnameUser,
               emailUser: emailUser,
               passwordUser: passwordUser
          })
     });

     if(response && !response.errors){
          Swal.fire({
               icon:'success',
               title:'Usuario creado'
          });
          
          setTimeout(()=>{
               window.location.reload();
          }, 1500);
     } else {
          let errorMsg = 'Error al crear el Usuario';
          if (response && response.errors) {
               errorMsg = Object.values(response.errors).flat().join('\n');
          }
          Swal.fire({
               icon:'error',
               title:'Error',
               text: errorMsg
          });
     }
});
