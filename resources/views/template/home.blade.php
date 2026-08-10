@extends('template.index')

@section('content')
<div class="main-panel w-100">
  <div class="content-wrapper">

    <!-- Cards de Resumen -->
    <div class="row mb-4">
      <div class="col-md-3 mb-3">
        <div class="card text-white" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
              <div>
                <h6 class="card-title text-white mb-1">Ventas del Mes</h6>
                <h3 class="mb-0 text-white" id="card-ventas-mes">$0.00</h3>
              </div>
              <i class="bi bi-cash-stack" style="font-size: 2.5rem; opacity: 0.7;"></i>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-3 mb-3">
        <div class="card text-white" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
              <div>
                <h6 class="card-title text-white mb-1">Clientes</h6>
                <h3 class="mb-0 text-white" id="card-clientes">0</h3>
              </div>
              <i class="bi bi-people-fill" style="font-size: 2.5rem; opacity: 0.7;"></i>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-3 mb-3">
        <div class="card text-white" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
              <div>
                <h6 class="card-title text-white mb-1">Productos</h6>
                <h3 class="mb-0 text-white" id="card-productos">0</h3>
              </div>
              <i class="bi bi-box-seam" style="font-size: 2.5rem; opacity: 0.7;"></i>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-3 mb-3">
        <div class="card text-white" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
              <div>
                <h6 class="card-title text-white mb-1">Cotizaciones (Mes)</h6>
                <h3 class="mb-0 text-white" id="card-cotizaciones">0</h3>
              </div>
              <i class="bi bi-file-earmark-text" style="font-size: 2.5rem; opacity: 0.7;"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Gráficas -->
    <div class="row">
      <!-- Ventas Mensuales -->
      <div class="col-md-8 mb-4">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Ventas Mensuales</h5>
            <canvas id="chartVentasMensuales" height="100"></canvas>
          </div>
        </div>
      </div>

      <!-- Estatus de Inventario -->
      <div class="col-md-4 mb-4">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Estatus de Inventario</h5>
            <canvas id="chartInventario"></canvas>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <!-- Top 5 Productos -->
      <div class="col-md-6 mb-4">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Top 5 Productos Más Vendidos</h5>
            <canvas id="chartTopProductos" height="150"></canvas>
          </div>
        </div>
      </div>

      <!-- Tabla resumen rápido -->
      <div class="col-md-6 mb-4">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Resumen de Inventario</h5>
            <div class="table-responsive">
              <table class="table table-sm" id="tablaInventario">
                <thead>
                  <tr>
                    <th>Estatus</th>
                    <th>Cantidad</th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/dashboard-widgets.js') }}"></script>
@endsection
