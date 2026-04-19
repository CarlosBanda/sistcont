@extends('template.index')

@section('content')
 <div class="card">
  <div class="card-body">

    <h4 class="card-title text-info">Nueva nota de venta</h4>

    <div class="row mt-4">

      <div class="col-md-6">

        <div class="form-group mb-3">
          <label>Serie</label>
          <input type="text" class="form-control">
        </div>

        <div class="form-group mb-3">
          <label>Cliente</label>
          <div class="d-flex">
            <select class="form-control me-2">
              <option>Genérico Nacional</option>
            </select>
            <a href="#" class="btn btn-link">Ver perfil</a>
          </div>
        </div>

        <div class="form-group">
          <label>Fecha de elaboración</label>
          <input type="date" class="form-control">
        </div>

      </div>

      <div class="col-md-6">

        <div class="form-group mb-3">
          <label>Folio</label>
          <input type="text" class="form-control" readonly>
          <small class="text-muted">Numeración automática</small>
        </div>

        <div class="form-group">
          <label>Vendedor</label>
          <input type="text" class="form-control" readonly>
        </div>

      </div>

    </div>

    <div class="table-responsive mt-4">
      <table class="table table-bordered align-middle text-center">
        <thead class="table-light">
          <tr>
            <th>#</th>
            <th>Producto</th>
            <th>Descripción</th>
            <th>Almacén</th>
            <th>Cant</th>
            <th>Valor Unitario</th>
            <th>% Desc.</th>
            <th>Impuesto</th>
            <th>Valor Total</th>
            <th></th>
          </tr>
        </thead>

        <tbody id="products-table">
          <tr>
            <td>1</td>

            <td>
              <input type="text" class="form-control" placeholder="Buscar">
            </td>

            <td>
              <input type="text" class="form-control">
            </td>

            <td>
              <input type="text" class="form-control">
            </td>

            <td>
              <input type="number" class="form-control" value="1">
            </td>

            <td>
              <input type="number" class="form-control" value="0.00">
            </td>

            <td>
              <input type="number" class="form-control" value="0">
            </td>

            <td>
              <input type="number" class="form-control" value="0.00">
            </td>

            <td>
              <input type="number" class="form-control" value="0.00" readonly>
            </td>

            <td>
              <button class="btn btn-danger btn-sm">🗑</button>
            </td>

          </tr>
        </tbody>
      </table>
    </div>

    <div class="text-end mt-3">
      <button class="btn btn-primary">Guardar venta</button>
    </div>

  </div>
</div>
@endsection