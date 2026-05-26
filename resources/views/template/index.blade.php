<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Sistcon</title>
  <!-- base:css -->
  <link rel="stylesheet" href="{{ asset('vendors/typicons/typicons.css') }}">
  <link rel="stylesheet" href="{{ asset('vendors/css/vendor.bundle.base.css') }}">
  <!-- endinject -->
  <!-- plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="{{ asset('css/vertical-layout-light/style.css') }}">
  <!-- endinject -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
  

</head>
<body>
  
  <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="navbar-brand-wrapper d-flex justify-content-center">
        <div class="navbar-brand-inner-wrapper d-flex justify-content-between align-items-center w-100">
          <a class="navbar-brand brand-logo" href="index.html"><img src="images/logo.svg" alt="logo"/></a>
          <a class="navbar-brand brand-logo-mini" href="index.html"><img src="images/logo-mini.svg" alt="logo"/></a>
          <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
            <span class="typcn typcn-th-menu"></span>
          </button>
        </div>
      </div>
      <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
        <ul class="navbar-nav mr-lg-2">
          <li class="nav-item nav-profile dropdown">
            <a class="nav-link" href="#" data-toggle="dropdown" id="profileDropdown">
              <img src="images/faces/face5.jpg" alt="profile"/>
                <span class="nav-profile-name" id="userName"></span>
            </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
              <a class="dropdown-item">
                <i class="typcn typcn-cog-outline text-primary"></i>
                Settings
              </a>
              <a class="dropdown-item" onclick="logout()">
                <i class="typcn typcn-eject text-primary"></i>
                Logout
              </a>
            </div>
          </li>
        </ul>
      </div>
    </nav>

    <div class="container-fluid page-body-wrapper">
  
      <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
              <i class="typcn typcn-document-text menu-icon"></i>
              <span class="menu-title">Clientes</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-basic">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="{{ route('clients') }}">Todos los Clientes</a></li>
                <li class="nav-item"> <a class="nav-link" href="{{ route('create-clients') }}">Crear clientes</a></li>
              </ul>
            </div>
          </li>

           <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-basic-ventas" aria-expanded="false" aria-controls="ui-basic">
              <i class="typcn typcn-shopping-cart menu-icon"></i>
              <span class="menu-title">Ventas</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-basic-ventas">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="{{ route('create-quotation')}}">Crear Cotizacion</a></li>
                <li class="nav-item"> <a class="nav-link" href="{{ route('quotation')}}">Ver Cotizacion</a></li>
                <li class="nav-item"> <a class="nav-link" href="{{ route('create-venta')}}">Nota de Venta</a></li>
                <li class="nav-item"> <a class="nav-link" href="">Facturacion</a></li>
              </ul>
            </div>
          </li>

           <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-basic-products" aria-expanded="false" aria-controls="ui-basic">
              <i class="typcn typcn-rss-outline menu-icon"></i>
              <span class="menu-title">Productos y Servicios</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-basic-products">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="{{ route('create-products')}}">Agregar productos</a></li>
                <li class="nav-item"> <a class="nav-link" href="{{ route('products')}}">Todos los productos</a></li>
                <li class="nav-item"> <a class="nav-link" href="{{ route('providers')}}">Proveedores</a></li>
                <li class="nav-item"> <a class="nav-link" href="pages/ui-features/buttons.html">Inventario</a></li>
              </ul>
            </div>
          </li>

           <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-basic-users" aria-expanded="false" aria-controls="ui-basic">
              <i class="typcn typcn-rss-outline menu-icon"></i>
              <span class="menu-title">Usuarios</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-basic-users">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="{{ route('users')}}">Usuarios</a></li>
                <li class="nav-item"> <a class="nav-link" href="{{ route('create-users')}}">Crear Usuario</a></li>
              </ul>
            </div>
          </li>
        </ul>
      </nav>
      <!-- partial -->
       <!-- body de la vista -->
      <div class="main-panel">
        <div class="content-wrapper">

          <!-- aqui se muestra el contenido de cada vista -->
          @yield('content')
       

        </div>
       </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->

  {{-- @yield('script'); --}}
  <!-- base:js -->
  <script src="{{ asset('vendors/js/vendor.bundle.base.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <!-- endinject -->
  <!-- Plugin js for this page-->
  <script src="{{ asset('vendors/chart.js/Chart.min.js') }}"></script>
  <!-- End plugin js for this page-->
  <!-- inject:js -->
  <script src="{{ asset('js/off-canvas.js') }}"></script>
  <script src="{{ asset('js/hoverable-collapse.js') }}"></script>
  <script src="{{ asset('js/template.js') }}"></script>
  <script src="{{ asset('js/settings.js') }}"></script>
  <script src="{{ asset('js/todolist.js') }}"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <script src="{{ asset('js/dashboard.js') }}"></script>
  {{-- <script src="/js/addProduct.js"></script> --}}
  <script src="/js/api.js"></script>
  <script src="/js/inactivity.js"></script>
  {{-- <script src="/js/quotations.js"></script> --}}
  {{-- <script src="/js/addQuotation.js"></script> --}}
  {{-- <script src="/js/clientPostalCode.js"></script> --}}
  {{-- <script src="/js/addClients.js"></script> --}}
  {{-- <script src="/js/quotations-list.js"></script> --}}
  {{-- <script src="/js/addUsers.js"></script> --}}
  <script>checkAuth();</script>
  <script>
    apiFetch('me').then(user => {
      if(user){
        document.getElementById('userName').textContent = user.name;
      }
    })
  </script>
  @yield('scripts')
</body>
</html>

