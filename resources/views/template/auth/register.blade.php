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

                         <form id="registerForm">

                              <h3>Crear cuenta</h3>

                              <div class="form-container">
                                   <div id="step1" class="step show">
                                        <div class="input-group">
                                             <input type="text" id="nameCompany" placeholder="Nombre" required>
                                        </div>

                                        <div class="input-group">
                                             <input type="text" id="razonSocial" placeholder="Razón Social" required>
                                        </div>

                                        <div class="input-group password-group">
                                             <input type="text" id="phoneCompany" placeholder="Teléfeno" required>
                                        </div>

                                        <div class="input-group password-group">
                                             <input type="email" id="emailCompany" placeholder="Email" required>
                                        </div>

                                        <div class="input-group">
                                             <textarea id="addressCompany" placeholder="Dirección"></textarea>
                                        </div>

                                        <button class="btn-login" type="button" id="buttonStep1">
                                             Continuar
                                        </button>
                                   </div>

                                   <div id="step2" class="step hidden-left">
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

                                        <div class="btn-accion">
                                             <button type="button" id="backStep" class="btn-login">
                                                  Regresar
                                             </button>

                                             <button class="btn-login" type="submit">
                                                  Registrarse
                                             </button>
                                        </div>

                                   </div>
                              </div>

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