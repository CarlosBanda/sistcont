@extends('template.index')

@section('content')

<div class="content-wrapper">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h4 class="card-title">Crear proveedor</h4>
                </div>
                <div class="col-md-6">

                    <form id="pdfForm" enctype="multipart/form-data">
                        @csrf
                        
                        <input type="file" name="pdf" accept=".pdf">
                        
                        <button class="btn btn-primary mr-2" type="submit">Cargar constancia</button>
                    </form>
                </div>
            </div>

            <form id="save-provider" class="form-sample">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                    <h4>Datos básicos</h4>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Tipo</label>
                                                <div class="col-sm-9">
                                                    <select id="type_person" name="tax_regime" class="form-control">
                                                        <option>Persona Fisica</option>
                                                        <option>Persona Moral</option>
                                                        <option>Otro</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label  class="col-sm-3 col-form-label">RFC</label>
                                                <div class="col-sm-9">
                                                    <input id="rfc" name="rfc" type="text" class="form-control" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Nombre Comercial</label>
                                                <div class="col-sm-9">
                                                    <input id="name_comercial" name="comercial" type="text" class="form-control" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label  class="col-sm-3 col-form-label">Razon Social</label>
                                                <div class="col-sm-9">
                                                    <input id="razon_social" name="razon" type="text" class="form-control" />
                                                </div>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Codigo postal</label>
                                                <div class="col-sm-9">
                                                    <input id="cp" type="text" name="cp" class="form-control" maxlength="5"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Colonia</label>
                                                <div class="col-sm-9">
                                                    <input id="colonia" name="colonia" class="form-control"/>
                                                    
                                               
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Ciudad</label>
                                                <div class="col-sm-9">
                                                    <input id="municipio" type="text" class="form-control" name="localidad" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Direccion</label>
                                                <div class="col-sm-9">
                                                    <input id="address" type="text" name="address" class="form-control" />
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Pais</label>
                                                <div class="col-sm-9">
                                                    <input id="pais" type="text" class="form-control" name="country" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Estado</label>
                                                <div class="col-sm-9">
                                                    <input id="ciudad" type="text" class="form-control" name="estado" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Numero exterior</label>
                                                <div class="col-sm-9">
                                                    <input id="num_ext" name="numeroExterior" type="text" class="form-control" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Estatus Padron</label>
                                                <div class="col-sm-9">
                                                    <input id="status" name="estatus" type="text" class="form-control" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <button type="submit"  class="btn btn-primary mr-2">Guardar</button>
                </div>

                                        
            </form>
        </div>
    </div>


<br>
<br>

    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Proveedores</h4>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Nombre Comercial</th>
                        <th>RFC</th>
                        <th>address</th>
                        <th>Estatus</th>
                        <th>Informacion</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($providers as $provider)
                        <tr>
                            <td>{{ $provider->name_comercial }}</td>
                            <td>{{ $provider->rfc }}</td>
                            <td>{{ $provider->address }}</td>
                            <td>{{ $provider->status }}</td>
                            <td><button id="{{$provider->id}}" class="btn btn-info">Info</button></td>
                        </tr>
                    @endforeach 
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>

    document.addEventListener("DOMContentLoaded", function () {
    
        const input = document.querySelector("#cp");
    
        input.addEventListener("input", async function () {
    
            if (this.value.length === 5) {
    
                const url = `https://api.copomex.com/query/info_cp/${this.value}?token=46556d12-eb2c-4cf1-acf6-0a2576978306`;
    
                const response = await fetch(url);
                const data = await response.json();
    
                const select = document.getElementById("colonia");
                data.forEach(item => {
    
                    const asentamiento = item.response.asentamiento;
    
                    const option = document.createElement("option");
    
                    document.getElementById("state_input").value = data[0].response.estado;
                    document.getElementById("city_input").value = data[0].response.municipio;
                    document.getElementById("pais").value = data[0].response.pais;
                    option.value = asentamiento;
                    option.textContent = asentamiento;
    
                    select.appendChild(option);
    
                });
    
                console.log(data);
    
            }
    
        });
    
    });

document.getElementById('pdfForm').addEventListener('submit', async function(e){

    e.preventDefault();

    let formData = new FormData(this);

    let response = await fetch('/leer-pdf', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    });

    let data = await response.json();

    document.getElementById('rfc').value = data.rfc;
    document.getElementById('name_comercial').value = data.comercial;
    document.getElementById('razon_social').value = data.razon;
    document.getElementById('cp').value = data.cp;
    document.getElementById('colonia').value = data.colonia;
    document.getElementById('municipio').value = data.localidad;
    document.getElementById('address').value = data.direccion;
    document.getElementById('ciudad').value = data.estado;
    document.getElementById('num_ext').value = data.numeroExterior;
    document.getElementById('status').value = data.estatus;

});



</script>

@endsection