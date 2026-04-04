@extends('template.index')

@section('content')

<div class="main-panel w-100">
  <div class="content-wrapper padding">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title text-nowrap">Productos</h4>
        <div class="table-responsive ">
          <table class="table table-striped table-bordered table-hover align-middle">
            <thead>
              <tr>
                <th class="text-nowrap">Categoria</th>
                <th>Nombre</th>
                <th >Código de producto</th>
                <th>Precio</th>
                {{-- <th>Código de barra</th>
                <th>Descripción</th>
                <th>Clave SAT</th> --}}
                {{-- <th>Unidad de medidas SAT</th> --}}
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="modalProducto">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Detalle del producto</h5>
        </div>
        <div class="modal-body" id="modalBody"></div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
     <script src="{{ asset('js/products.js') }}"></script>
@endsection