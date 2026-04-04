<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="stylesheet" href="{{ asset('css/login/login.css')}}">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <title>Sistcont Login</title>
</head>

<body>

  <div class="container">

    <div class="left">

    <div class="title">SISTCONT</div>

    <div class="login-card">

    <h3>Login</h3>

      <form id="loginForm">

        <div class="input-group">
          <input type="email" id="email" placeholder="Email Address" required>
        </div>

        <div class="input-group password-group">
          <input type="password" id="password" placeholder="Password" required>
          <i class="fa-solid fa-eye toggle-password" id="togglePassword"></i>
        </div>

        <button class="btn-login" type="submit" id="loginBtn">
          <span id="btnText">Iniciar Sesión</span>
          <i class="fa-solid fa-spinner loader" id="loader"></i>
        </button>
        
        <div class="session">
          ¿No tienes cuenta? <a href="{{ route('register')}}" class="register">Registrase</a>
        </div>

        <p id="error"></p>

      </form>

    </div>

  </div>

  <div class="right">
    <img src="{{ asset('images/login/login.jpg')}}">
  </div>

  </div>
  
</body>
  <script src="{{ asset('js/login.js') }}"></script>
</html>