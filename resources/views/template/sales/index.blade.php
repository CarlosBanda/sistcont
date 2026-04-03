@extends('template.index')

@section('content')
    <div class="row">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Crear Venta</h4>
                <form id="save-client" class="form-sample">

                    <div class="row">
                        <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Nombres</label>
                            <div class="col-sm-9">
                            <input id="name_input" name="name" type="text" class="form-control" />
                            </div>
                        </div>
                        </div>
                        <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Apellidos</label>
                            <div class="col-sm-9">
                                <input id="lastname_input" name="lastname" type="text" class="form-control" />
                            </div>
                        </div>
                        </div>
                    </div>
                  
                           
 
         
                    <button type="submit"  class="btn btn-primary mr-2">Guardar</button>

                </form>
            </div>
        </div>
    </div>

<script>




</script>
@endsection