@extends('template.index')

@section('content')

<div class="main-panel">
        <div class="content-wrapper">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Clientes</h4>
                  <div class="table-responsive">
                    <table class="table">
                      <thead>
                        <tr>
                          <th>Nombre</th>
                          <th>Direccion</th>
                          <th>Telefono</th>
                          <th>RFC</th>
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

        <!-- Modal Editar Cliente -->
        <div class="modal fade" id="modalEditClient" tabindex="-1" aria-labelledby="modalEditClientLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="modalEditClientLabel">Editar Cliente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <form id="formEditClient">
                  <input type="hidden" id="edit_client_id">
                  <div class="row">
                    <div class="col-md-6 mb-3">
                      <label class="form-label">Nombre</label>
                      <input type="text" class="form-control" id="edit_client_name">
                    </div>
                    <div class="col-md-6 mb-3">
                      <label class="form-label">RFC</label>
                      <input type="text" class="form-control" id="edit_client_rfc" maxlength="13">
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6 mb-3">
                      <label class="form-label">Email</label>
                      <input type="email" class="form-control" id="edit_client_email">
                    </div>
                    <div class="col-md-6 mb-3">
                      <label class="form-label">Teléfono</label>
                      <input type="text" class="form-control" id="edit_client_phone" maxlength="20">
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6 mb-3">
                      <label class="form-label">Código Postal</label>
                      <input type="text" class="form-control" id="edit_client_zip_code" maxlength="10">
                    </div>
                    <div class="col-md-6 mb-3">
                      <label class="form-label">Colonia</label>
                      <input type="text" class="form-control" id="edit_client_colony">
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12 mb-3">
                      <label class="form-label">Dirección</label>
                      <input type="text" class="form-control" id="edit_client_address">
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-3 mb-3">
                      <label class="form-label">Num. Ext.</label>
                      <input type="text" class="form-control" id="edit_client_number_ext">
                    </div>
                    <div class="col-md-3 mb-3">
                      <label class="form-label">Num. Int.</label>
                      <input type="text" class="form-control" id="edit_client_number_int">
                    </div>
                    <div class="col-md-3 mb-3">
                      <label class="form-label">Ciudad</label>
                      <input type="text" class="form-control" id="edit_client_city">
                    </div>
                    <div class="col-md-3 mb-3">
                      <label class="form-label">Estado</label>
                      <input type="text" class="form-control" id="edit_client_state">
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6 mb-3">
                      <label class="form-label">País</label>
                      <input type="text" class="form-control" id="edit_client_country">
                    </div>
                  </div>
                </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btnSaveClient">Guardar Cambios</button>
              </div>
            </div>
          </div>
        </div>
</div>
@endsection
@section('scripts')
     <script src="{{ asset('js/clients.js') }}"></script>
@endsection
