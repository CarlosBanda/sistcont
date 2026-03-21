<!DOCTYPE html>
<html>
     <head>

          <meta name="csrf-token" content="{{ csrf_token() }}">

          <link rel="stylesheet" href="{{ asset('css/login/login.css')}}">
          <link rel="stylesheet"href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
          <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

          <title>Registro</title>

     </head>

     <body>

          <div class="container">

               <div class="left">

                    <div class="title">SISTCONT</div>

                    <div class="login-card">

                         <h3>Crear cuenta</h3>

                         <form id="registerForm">

                              <div class="input-group">
                                   <input type="text" id="name" placeholder="Nombre" required>
                              </div>

                              <div class="input-group">
                                   <input type="email" id="email" placeholder="Email" required>
                              </div>

                              <div class="input-group password-group">
                                   <input type="password" id="password" placeholder="Password" required>
                                   <i class="fa-solid fa-eye toggle-password" id="togglePassword"></i>
                              </div>

                              <button class="btn-login" type="submit">
                                   Registrarse
                              </button>

                              <div class="session">
                                   ¿Ya tienes cuenta? 
                                   <a href="/login" class="register">Iniciar sesión</a>
                              </div>

                         </form>

                    </div>

               </div>

               <div class="right">
                    <img src="{{ asset('images/login/register.png')}}">
               </div>

          </div>

          <script src="{{ asset('js/register.js') }}"></script>

     </body>
</html>