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

    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Proveedores</h4>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Nombre Comercial</th>
                        <th>RFC</th>
                        <th>Dirección</th>
                        <th>Estatus</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($providers as $provider)
                        <tr>
                            <td>{{ $provider->name_comercial }}</td>
                            <td>{{ $provider->rfc }}</td>
                            <td>{{ $provider->address }}</td>
                            <td>{{ $provider->status }}</td>
                            <td>
                                <button class="btn btn-success btn-sm btn-edit-provider"
                                    data-id="{{ $provider->id }}"
                                    data-name_comercial="{{ $provider->name_comercial }}"
                                    data-rfc="{{ $provider->rfc }}"
                                    data-razon_social="{{ $provider->razon_social }}"
                                    data-status="{{ $provider->status }}"
                                    data-cp="{{ $provider->cp }}"
                                    data-ciudad="{{ $provider->ciudad }}"
                                    data-num_ext="{{ $provider->num_ext }}"
                                    data-municipio="{{ $provider->municipio }}"
                                    data-colonia="{{ $provider->colonia }}"
                                    data-address="{{ $provider->address }}"
                                    data-pais="{{ $provider->pais }}">Info</button>
                            </td>
                        </tr>
                    @endforeach 
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Editar Proveedor -->
    <div class="modal fade" id="modalEditProvider" tabindex="-1" aria-labelledby="modalEditProviderLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalEditProviderLabel">Editar Proveedor</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form id="formEditProvider">
              <input type="hidden" id="edit_provider_id">
              <div class="row">
                <div class="col-md-6 mb-3">
                  <label class="form-label">Nombre Comercial</label>
                  <input type="text" class="form-control" id="edit_provider_name_comercial">
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label">RFC</label>
                  <input type="text" class="form-control" id="edit_provider_rfc" maxlength="13">
                </div>
              </div>
              <div class="row">
                <div class="col-md-6 mb-3">
                  <label class="form-label">Razón Social</label>
                  <input type="text" class="form-control" id="edit_provider_razon_social">
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label">Estatus</label>
                  <input type="text" class="form-control" id="edit_provider_status">
                </div>
              </div>
              <div class="row">
                <div class="col-md-6 mb-3">
                  <label class="form-label">Código Postal</label>
                  <input type="text" class="form-control" id="edit_provider_cp" maxlength="5">
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label">Colonia</label>
                  <input type="text" class="form-control" id="edit_provider_colonia">
                </div>
              </div>
              <div class="row">
                <div class="col-md-6 mb-3">
                  <label class="form-label">Ciudad / Municipio</label>
                  <input type="text" class="form-control" id="edit_provider_municipio">
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label">Estado</label>
                  <input type="text" class="form-control" id="edit_provider_ciudad">
                </div>
              </div>
              <div class="row">
                <div class="col-md-6 mb-3">
                  <label class="form-label">Dirección</label>
                  <input type="text" class="form-control" id="edit_provider_address">
                </div>
                <div class="col-md-3 mb-3">
                  <label class="form-label">Num. Ext.</label>
                  <input type="text" class="form-control" id="edit_provider_num_ext">
                </div>
                <div class="col-md-3 mb-3">
                  <label class="form-label">País</label>
                  <input type="text" class="form-control" id="edit_provider_pais">
                </div>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button type="button" class="btn btn-primary" id="btnSaveProvider">Guardar Cambios</button>
          </div>
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
                document.getElementById("ciudad").value = data[0].response.estado;
                document.getElementById("municipio").value = data[0].response.municipio;
                document.getElementById("pais").value = data[0].response.pais;
                option.value = asentamiento;
                option.textContent = asentamiento;
                select.appendChild(option);
            });
        }
    });

    // PDF Form
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

    // Botones Info de proveedores
    document.querySelectorAll('.btn-edit-provider').forEach(btn => {
        btn.addEventListener('click', function() {
            document.getElementById('edit_provider_id').value = this.dataset.id;
            document.getElementById('edit_provider_name_comercial').value = this.dataset.name_comercial || '';
            document.getElementById('edit_provider_rfc').value = this.dataset.rfc || '';
            document.getElementById('edit_provider_razon_social').value = this.dataset.razon_social || '';
            document.getElementById('edit_provider_status').value = this.dataset.status || '';
            document.getElementById('edit_provider_cp').value = this.dataset.cp || '';
            document.getElementById('edit_provider_colonia').value = this.dataset.colonia || '';
            document.getElementById('edit_provider_municipio').value = this.dataset.municipio || '';
            document.getElementById('edit_provider_ciudad').value = this.dataset.ciudad || '';
            document.getElementById('edit_provider_address').value = this.dataset.address || '';
            document.getElementById('edit_provider_num_ext').value = this.dataset.num_ext || '';
            document.getElementById('edit_provider_pais').value = this.dataset.pais || '';

            let modal = new bootstrap.Modal(document.getElementById('modalEditProvider'));
            modal.show();
        });
    });

    // Guardar proveedor
    document.getElementById('btnSaveProvider').addEventListener('click', function() {
        const providerId = document.getElementById('edit_provider_id').value;

        const data = {
            name_comercial: document.getElementById('edit_provider_name_comercial').value,
            rfc: document.getElementById('edit_provider_rfc').value,
            razon_social: document.getElementById('edit_provider_razon_social').value,
            status: document.getElementById('edit_provider_status').value,
            cp: document.getElementById('edit_provider_cp').value,
            colonia: document.getElementById('edit_provider_colonia').value,
            municipio: document.getElementById('edit_provider_municipio').value,
            ciudad: document.getElementById('edit_provider_ciudad').value,
            address: document.getElementById('edit_provider_address').value,
            num_ext: document.getElementById('edit_provider_num_ext').value,
            pais: document.getElementById('edit_provider_pais').value,
        };

        apiFetch(`providers/${providerId}`, {
            method: 'PUT',
            body: JSON.stringify(data)
        }).then(response => {
            if (response.success) {
                alert('Proveedor actualizado correctamente');
                let modal = bootstrap.Modal.getInstance(document.getElementById('modalEditProvider'));
                modal.hide();
                location.reload();
            } else {
                alert('Error al actualizar: ' + (response.message || 'Intente de nuevo'));
            }
        }).catch(err => {
            alert('Error de conexión');
            console.error(err);
        });
    });
});

</script>

@endsection
