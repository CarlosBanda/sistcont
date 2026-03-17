const form = document.getElementById("registerForm");
const togglePassword = document.getElementById('togglePassword');
const passwordInput = document.getElementById('password');

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

form.addEventListener("submit", async function(e){

     e.preventDefault();

     let name = document.getElementById("name").value;
     let email = document.getElementById("email").value;
     let password = document.getElementById("password").value;

     let response = await fetch("/register",{

     method:"POST",

     headers:{
          "Content-Type":"application/json",
          "X-CSRF-TOKEN":document.querySelector('meta[name="csrf-token"]').getAttribute("content")
     },

     body:JSON.stringify({
          name:name,
          email:email,
          password:password
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