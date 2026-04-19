@extends('template.index')

@section('content')
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Nueva Cotización</h4>

        <form id="save-quotation">

          <!-- aquí van los campos -->
          <div class="row">
               <div class="col-md-6">
               <div class="form-group">
                    <label>Serie</label>
                    <input type="text" id="serie" name="serie" class="form-control">
               </div>
               </div>

               <div class="col-md-6">
               <div class="form-group">
                    <label>Folio</label>
                    <input type="text" id="folio" name="folio" class="form-control" readonly>
               </div>
               </div>
          </div>

          <div class="form-group">
               <label>Cliente</label>
                    <select id="client_id" name="client_id" class="form-control">
               </select>
          </div>

          <div class="form-group">
               <label>Nombre de contacto</label>
               <input type="text" id="contact_name" name="contact_name" class="form-control">
          </div>

          <div class="form-group">
               <label>Responsable de la cotización</label>
               <input type="text" id="user_name" name="user_name" class="form-control" readonly>
          </div>

          <div class="row">
               <div class="col-md-6">
                    <div class="form-group">
                         <label>Fecha de elaboración</label>
                         <input type="date" id="quotation_date" name="quotation_date" class="form-control">
                    </div>
               </div>

               <div class="col-md-6">
                    <div class="form-group">
                         <label>Moneda</label>
                         <select id="currency" name="currency" class="form-control">
                         <option value="MXN">MXN</option>
                         <option value="USD">USD</option>
                         </select>
                    </div>    
               </div>

               <div class="mt-3 text-end">
                    <button type="submit" class="btn btn-primary">
                         Guardar cotización
                    </button>
               </div>
          </div>

        </form>

      </div>
    </div>
@endsection

