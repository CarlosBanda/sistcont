const form = document.getElementById('loginForm'); 
const togglePassword = document.getElementById('togglePassword');
const passwordInput = document.getElementById('password');

const loader = document.getElementById('loader');
const btnText = document.getElementById('btnText');

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
  
form.addEventListener('submit', async function(e){

  e.preventDefault();

  let email=document.getElementById('email').value;
  let password=passwordInput.value;

  loader.classList.add("active");
  btnText.style.display="none";

  let response = await fetch('/api/login',{
    method:'POST',
    headers:{
    'Content-Type':'application/json',
    },
    body:JSON.stringify({
      email:email,
      password:password
    })
  });

  loader.classList.remove("active");
  btnText.style.display = "inline";

  if(response.ok){

    let data = await response.json();

    localStorage.setItem('token', data.token);

    Swal.fire({
      icon:'success',
      title:'Bienvenido',
      text:'Acceso correcto',
      timer:1200,
      showConfirmButton:false
    });
    setTimeout(()=> {
      window.location.href="/";
    },1500);
    
  }else{
    Swal.fire({
      icon:'error',
      title:'Error',
      text:'Credenciales incorrectas'
    });
  }

});