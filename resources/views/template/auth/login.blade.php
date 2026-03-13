<!DOCTYPE html>
<html>
<head>
<title>Login</title>
</head>

<body>

<h2>Login</h2>

<form id="loginForm">
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Name</label>
    <input type="text" name="name" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
    <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
  </div>
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Email address</label>
    <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
    <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Password</label>
    <input type="password" name="password" class="form-control" id="exampleInputPassword1">
  </div>
  <div class="mb-3 form-check">
    <input type="checkbox" class="form-check-input" id="exampleCheck1">
    <label class="form-check-label" for="exampleCheck1">Check me out</label>
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>

<script>

document.getElementById('loginForm').addEventListener('submit', async function(e){

    e.preventDefault();

    const email = document.querySelector('[name=email]').value;
    const password = document.querySelector('[name=password]').value;
    const name = document.querySelector('[name=name]').value;

    const response = await fetch('/api/register',{
        method:'POST',
        headers:{
            'Content-Type':'application/json'
        },
        body: JSON.stringify({
            email:email,
            password:password,
            name:name
        })
    });

    const data = await response.json();

    if(data.token){

        localStorage.setItem('token',data.token);

        window.location = "/dashboard";

    }else{

        alert("Credenciales incorrectas");

    }

});

</script>

</body>
</html>