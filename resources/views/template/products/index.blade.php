@extends('template.index')

@section('content')

<div class="main-panel w-100">
  <div class="content-wrapper padding">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title text-nowrap">Productos</h4>
        <div class="table-responsive">
          <table class="table table-striped table-bordered table-hover align-middle">
            <thead>
              <tr>
                <th class="text-nowrap">Modelo</th>
                <th>Nombre</th>
                <th>Tipo Precio</th>
                <th>Precio</th>
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

  <!-- Modal Editar Producto -->
  <div class="modal fade" id="modalEditProduct" tabindex="-1" aria-labelledby="modalEditProductLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalEditProductLabel">Editar Producto</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="formEditProduct">
            <input type="hidden" id="edit_product_id">
            <div class="row">
              <div class="col-md-6 mb-3">
                <label class="form-label">Modelo</label>
                <input type="text" class="form-control" id="edit_product_modelo">
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label">Nombre</label>
                <input type="text" class="form-control" id="edit_product_nombre">
              </div>
            </div>
            <div class="row">
              <div class="col-md-6 mb-3">
                <label class="form-label">Unidad de Medida (ID)</label>
                <input type="number" class="form-control" id="edit_product_unidad">
              </div>
            </div>
            <hr>
            <h6>Precios</h6>
            <div id="edit_product_prices_container">
              <!-- Se llena dinámicamente -->
            </div>
            <button type="button" class="btn btn-sm btn-outline-primary mt-2" id="btnAddPrice">+ Agregar precio</button>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="button" class="btn btn-primary" id="btnSaveProduct">Guardar Cambios</button>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
     <script src="{{ asset('js/products.js') }}"></script>
@endsection
