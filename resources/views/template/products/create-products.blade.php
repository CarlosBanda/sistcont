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
                                             <h4>Datos básicos</h4>
                                             <div class="row">
                                                  <div class="col-md-6">
                                                       <div class="form-group row">
                                                            <label class="col-sm-3 col-form-label">Categroia del prodcuto</label>
                                                            <div class="col-sm-9">
                                                                 <select id="product_category" name="product_category" class="form-control">
                                                                      <option>-- SELECCIONA --</option>
                                                                      <option id="1" name="Accesosrios">Accesorios</option>
                                                                      <option id="2" name="Cámaras IP y NVRs">Cámaras IP y NVRs</option>
                                                                      <option id="3" name="Accessorios Laptop">Accesorios para laptop</option>
                                                                 </select>
                                                            </div>
                                                       </div>
                                                  </div>

                                                  <div class="col-md-6">
                                                       <div class="form-group row">
                                                            <label class="col-sm-3 col-form-label">Código de producto</label>
                                                            <div class="col-sm-9">
                                                                 <input id="product_code" name="product_code" type="text" class="form-control" />
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
                                                            <label  class="col-sm-3 col-form-label">Precio</label>
                                                            <div class="col-sm-9">
                                                                 <input id="product_price" name="product_price" type="text" class="form-control" />
                                                            </div>
                                                       </div>
                                                  </div>
                                             </div>
                                        </div>
                                   </div>
                              </div>

                              <div class="col-md-12 mt-3">
                                   <div class="card">
                                        <div class="card-body">
                                             <h4>Inventario</h4>
                                             <div class="row">
                                                  <div class="col-md-6">
                                                       <div class="form-group row">
                                                            <label class="col-sm-3 col-form-label">Código de barra</label>
                                                            <div class="col-sm-9">
                                                                 <input id="product_bar" name="product_bar" type="text" class="form-control" />
                                                            </div>
                                                       </div>
                                                  </div>
                                                  <div class="col-md-6">
                                                       <div class="form-group row">
                                                            <label class="col-sm-3 col-form-label">Descripción</label>
                                                            <div class="col-sm-9">
                                                                 <input id="product_description" name="product_description" type="text" class="form-control" />
                                                            </div>
                                                       </div>
                                                  </div>
                                             </div>
                                        </div>
                                   </div>
                              </div>

                              <div class="col-md-12 mt-3">
                                   <div class="card">
                                        <div class="card-body">
                                             <h4>Datos fiscales</h4>
                                             <div class="row">
                                                  <div class="col-md-6">
                                                       <div class="form-group row">
                                                            <label class="col-sm-3 col-form-label">Clave SAT</label>
                                                            <div class="col-sm-9">
                                                                 <select id="product_sat" name="product_sat" class="form-control">
                                                                      <option id="01010101">01010101 - No existe en el catálogo</option>
                                                                      <option id="10101500">10101500 - Animales vivos de granja</option>
                                                                      <option id="10101501">10101501 -  Gatos  vivos</option>
                                                                      <option id="10101502">10101502 -  Perros</option>
                                                                      <option id="10101504">10101504 -  Visión</option>
                                                                      <option id="10101505">10101505 -  Ratas</option>
                                                                      <option id="10101505">10101505 -  Caballos</option>
                                                                 </select>
                                                            </div>
                                                       </div>
                                                  </div>
                                                  <div class="col-md-6">
                                                       <div class="form-group row">
                                                            <label class="col-sm-3 col-form-label">Unidad de medida SAT</label>
                                                            <div class="col-sm-9">
                                                                 <select id="product_unit" name="product_unit" class="form-control">
                                                                      <option id="05">05 - Ascensor</option>
                                                                      <option id="06">06 - Pequeño aerosol</option>
                                                                 </select>
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