const form = document.getElementById("registerForm");
const togglePassword = document.getElementById('togglePassword');
const passwordInput = document.getElementById('password');

const buttonStep1 = document.getElementById('buttonStep1');
const step1 = document.getElementById('step1');
const step2 = document.getElementById('step2');

const formContainer = document.querySelector('.form-container');

const backStep = document.getElementById('backStep');

togglePassword.addEventListener('click', function(){
  if(passwordInput.type === "password"){
    passwordInput.type = "text";
    this.classList.remove("fa-eye");
    this.classList.add("fa-eye-slash");
  }else{
    passwordInput.type = "password";
    this.classList.remove("fa-eye-slash");
    this.classList.add("fa-eye");
  }

});

window.addEventListener('load', () => {
     formContainer.style.height = step1.offsetHeight + "px";
});

buttonStep1.addEventListener('click', function(){

     step1.classList.remove('show');
     step1.classList.add('hidden-left');
     
     step2.classList.remove('hidden-left');
     step2.classList.add('show')

     formContainer.style.height = step2.offsetHeight + "px";
});

backStep.addEventListener('click', function(){
     step1.classList.remove('hidden-left');
     step1.classList.add('show');

     step2.classList.remove('show');
     step2.classList.add('hidden-left');

     formContainer.style.height = step1.offsetHeight + "px";
})

form.addEventListener("submit", async function(e){

     e.preventDefault();

     let nameCompany = document.getElementById("nameCompany").value;
     let razonSocial = document.getElementById("razonSocial").value;
     let phoneCompany = document.getElementById("phoneCompany").value;
     let emailCompany = document.getElementById("emailCompany").value;
     let addressCompany = document.getElementById("addressCompany").value;

     let name = document.getElementById("name").value;
     let email = document.getElementById("email").value;
     let password = document.getElementById("password").value;

     // Validar contraseña en el frontend
     if (password.length < 8) {
          Swal.fire({ icon: 'warning', title: 'Contraseña muy corta', text: 'La contraseña debe tener al menos 8 caracteres.' });
          return;
     }
     if (!/[A-Z]/.test(password)) {
          Swal.fire({ icon: 'warning', title: 'Contraseña insegura', text: 'Debe incluir al menos una letra mayúscula.' });
          return;
     }
     if (!/[a-z]/.test(password)) {
          Swal.fire({ icon: 'warning', title: 'Contraseña insegura', text: 'Debe incluir al menos una letra minúscula.' });
          return;
     }
     if (!/[0-9]/.test(password)) {
          Swal.fire({ icon: 'warning', title: 'Contraseña insegura', text: 'Debe incluir al menos un número.' });
          return;
     }
     if (!/[@$!%*?&#]/.test(password)) {
          Swal.fire({ icon: 'warning', title: 'Contraseña insegura', text: 'Debe incluir al menos un carácter especial (@$!%*?&#).' });
          return;
     }

     let response = await fetch("/api/register",{
     
     method:"POST",

     headers:{
          "Content-Type":"application/json"
     },

     body:JSON.stringify({
          user: {
               name:name,
               email:email,
               password:password
          },
          company: {
               nameCompany: nameCompany,
               razonSocial: razonSocial,
               phoneCompany: phoneCompany,
               emailCompany: emailCompany,
               addressCompany: addressCompany
          }
     })

     });

     if(response.ok){

          Swal.fire({
               icon:'success',
               title:'Cuenta creada'
          });

          setTimeout(()=>{
          window.location.href="/login";
          },1500);

     }else{
          let errorData = await response.json();
          let errorMsg = 'Error al registrar';

          if (errorData.errors) {
               errorMsg = Object.values(errorData.errors).flat().join('\n');
          } else if (errorData.message) {
               errorMsg = errorData.message;
          }

          Swal.fire({
               icon:'error',
               title:'Error al registrar',
               text: errorMsg
          });
     }
});