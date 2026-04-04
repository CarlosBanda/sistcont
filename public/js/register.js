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

          Swal.fire({
               icon:'error',
               title:'Error al registrar'
          });

     }
});