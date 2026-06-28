@extends('template.index')

@section('content')

<div class="content-wrapper">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h4 class="card-title">Inventario</h4>
                </div>
            </div>

            <form id="save-inventory" class="form-sample">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <h4>Agregar producto a inventario</h4>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Producto</label>
                                                <div class="col-sm-9">
                                                    <select id="product" name="product_id" class="form-control">
                                                        <option value="">Seleccionar producto</option>
                                                        @foreach($productos as $product)
                                                            <option value="{{ $product->id }}">{{ $product->nombre }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label  class="col-sm-3 col-form-label">Numero de serie</label>
                                                <div class="col-sm-9">
                                                    <input id="numero_serie" name="numero_serie" type="text" class="form-control" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Codigo de barras</label>
                                                <div class="col-sm-9">
                                                    <input id="codigo_barras" name="codigo_barras" type="text" class="form-control" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label  class="col-sm-3 col-form-label">Garantia</label>
                                                <div class="col-sm-9">
                                                    <input id="garantia" name="garantia" type="text" class="form-control" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>
                    <br>
                </div>
                <button type="submit"  class="btn btn-primary mr-2">Guardar</button>

                                        
            </form>
        </div>
    </div>



    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Productos en inventario</h4>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Nombre Producto</th>
                        <th>Numero de serie</th>
                        <th>Garantia</th>
                        <th>Estatus</th>
                        <th>Acción</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($productos_inventory as $inventory)
                            <tr>
                                <td>{{ $inventory->product_name }}</td>
                                <td>{{ $inventory->numero_serie }}</td>
                                <td>{{ $inventory->garantia }}</td>
                                <td>{{ $inventory->estatus }}</td>
                                <td>
                                    <button class="btn btn-danger" value="{{$inventory->id}}" onclick="sellInventory({{ $inventory->id }})">Vender</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

@section('scripts')
     <script src="{{ asset('js/addInventory.js') }}"></script>
@endsection

@endsection