@extends('template.index')

@section('content')
     <div class="row">
          <div class="card">
               <div class="card-body">
                    <h4 class="card-title">Crear Productos</h4>
                    <form id="save-product" class="form-sample">

                         <div class="row">
                              <div class="col-md-12">
                                   <div class="card">
                                        <div class="card-body">
                                             <div class="row">
                                                  <div class="col-md-6">
                                                       <div class="form-group row">
                                                            <label class="col-sm-3 col-form-label">Modelo</label>
                                                            <div class="col-sm-9">
                                                                 <input id="product_model" name="product_model" type="text" class="form-control" />
                                                            </div>
                                                       </div>
                                                  </div>

                                                  <div class="col-md-6">
                                                       <div class="form-group row">
                                                            <label class="col-sm-3 col-form-label">Nombre del producto</label>
                                                            <div class="col-sm-9">
                                                                 <input id="product_name" name="product_name" type="text" class="form-control" />
                                                            </div>
                                                       </div>
                                                  </div>

                                                  <div class="col-md-6">
                                                       <div class="form-group row">
                                                            <label class="col-sm-3 col-form-label">Unidad de medida</label>
                                                            <div class="col-sm-9">
                                                                 <select id="product_unit" name="product_unit" class="form-control">
                                                                      <option value="05">05 - Ascensor</option>
                                                                      <option value="06">06 - Pequeño aerosol</option>
                                                                 </select>
                                                            </div>
                                                       </div>
                                                  </div>

                                                  <div class="col-md-6">
                                                       <div class="form-group row">
                                                            <label class="col-sm-3 col-form-label">Precios</label>

                                                            <div class="col-sm-9">
                                                                 <div id="prices-container">
                                                                      <div class="price-item mb-2">
                                                                           <div class="row">
                                                                           <div class="col-md-6">
                                                                                <input type="text" class="form-control price-type" placeholder="Base">
                                                                           </div>
                                                                           <div class="col-md-6">
                                                                                <input type="number" class="form-control price-value" placeholder="Precio">
                                                                           </div>
                                                                           <div class="col-md-2"></div>
                                                                           </div>
                                                                      </div>
                                                                 </div>

                                                                 <button type="button" id="add-price" class="btn btn-success btn-sm mt-2">
                                                                      + Agregar precio
                                                                 </button>

                                                            </div>
                                                       </div>
                                                  </div>
                                             </div>
                                        </div>
                                   </div>
                              </div>
                         </div>
                         <div class="mt-2 d-flex justify-content-end">
                              <button type="submit"  class="btn btn-primary mr-2">Guardar</button>
                         </div>
                    </form>
               </div>
          </div>
     </div>
@endsection

@section('scripts')
     <script src="{{ asset('js/addProduct.js') }}"></script>
@endsection