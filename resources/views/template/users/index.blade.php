@extends('template.index')

@section('content')

<div class="main-panel w-100">
  <div class="content-wrapper padding">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title text-nowrap">Usuarios</h4>
        <div class="table-responsive ">
          <table class="table table-striped table-bordered table-hover align-middle">
            <thead>
              <tr>
                <th class="text-nowrap">Nombre</th>
                <th>Apellidos</th>
                <th >Email</th>
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
  {{-- <div class="modal fade" id="modalProducto">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Detalles del usuario</h5>
        </div>
        <div class="modal-body" id="modalBody"></div>
      </div>
    </div>
  </div> --}}
</div>
@endsection
