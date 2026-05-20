@extends('template.index')

@section('content')
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Nueva Cotización</h4>

        <form id="save-quotation">

          <div class="row">

               <div class="col-md-6">
               <div class="form-group">
                    <label>Folio</label>
                    <input type="text" id="folio" name="folio" class="form-control" readonly>
                    <div class="mt-3">
                         <button type="button" class="btn btn-gradient mt-2 fw-semibold" onclick="generateFolio('COT')">
                             <i class="bi bi-file-earmark-text"></i>
                              Generar Folio
                         </button>
                    </div>
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
               <select id="user_id" name="user_id" class="form-control"></select>
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
                         <option value="MXN">MXN - Peso mexicano</option>
                         <option value="USD">USD - Dólar estadounidense</option>
                         </select>
                    </div>    
               </div>

               <div class="table-responsive mt-4">
                    <table class="table table-bordered align-middle text-center">
                         <thead class="table-light">
                              <tr>
                              <th>#</th>
                              <th>Producto</th>
                              <th>Descripción</th>
                              <th>Cant</th>
                              <th>Valor Unitario</th>
                              <th>% Desc.</th>
                              <th>Impuesto IVA</th>
                              <th>Valor Total</th>
                              <th></th>
                              </tr>
                         </thead>

                         <tbody id="products-table">
                              <tr>
                              <td>1</td>

                              <td style="position: relative;">
                              <input type="text" class="form-control search-product" placeholder="Buscar">
                                   <div class="dropdown-products"></div>
                              </td>

                              <td>
                              <input type="text" class="form-control desc">
                              </td>

                              <td>
                              <input type="number" class="form-control qty" value="1">
                              </td>

                              <td>
                              <input type="number" class="form-control price" value="0.00">
                              </td>

                              <td>
                              <input type="number" class="form-control discount" value="0">
                              </td>

                              <td>
                                   <select class="form-control tax-rate">
                                        <option value="0">Sin IVA</option>
                                        <option value="0.16">IVA %16</option>
                                        <option value="0.18">IVA %18</option>
                                   </select>
                              </td>

                              <td>
                              <input type="number" class="form-control total" value="0.00" readonly>
                              </td>

                              <td>
                              <button class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>
                              </td>

                              </tr>
                         </tbody>
                    </table>
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

@section('scripts')
     <script src="{{ asset('js/quotations.js') }}"></script>
     <script src="{{ asset('js/addQuotation.js') }}"></script>
@endsection