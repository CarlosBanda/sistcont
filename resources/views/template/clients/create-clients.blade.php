@extends('template.index')

@section('content')
    <div class="row">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Crear Cliente</h4>
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
                    <div class="row">
                        <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Correo Electrónico</label>
                            <div class="col-sm-9">
                                <input id="email_input" name="email" type="email" class="form-control" />
                            </div>
                        </div>
                        </div>
                        <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Teléfono</label>
                            <div class="col-sm-9">
                                <input id="phone_input" name="phone" type="text" class="form-control" />
                            </div>
                        </div>
                        </div>
                    </div>
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
                                    <input id="rfc_input_field" name="rfc" type="text" class="form-control" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Codigo postal</label>
                                <div class="col-sm-9">
                                    <input id="cp_input" type="text" name="zip_code" class="form-control" maxlength="5"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Colonia</label>
                                <div class="col-sm-9">
                                    <select id="colonia_input" name="colony" class="form-control">
                                       
                                   </select>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Ciudad</label>
                                <div class="col-sm-9">
                                    <input id="city_input" type="text" class="form-control" name="city" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Direccio</label>
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
                                    <input id="country_input" type="text" class="form-control" name="country" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Estado</label>
                                <div class="col-sm-9">
                                    <input id="state_input" type="text" class="form-control" name="state" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Numero exterior</label>
                                <div class="col-sm-9">
                                    <input id="number_ext_input" name="number_ext" type="text" class="form-control" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Numero interior</label>
                                <div class="col-sm-9">
                                    <input id="number_int_input" name="number_int" type="text" class="form-control" />
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

document.addEventListener("DOMContentLoaded", function () {

    const input = document.querySelector("#cp_input");

    input.addEventListener("input", async function () {

        if (this.value.length === 5) {

            const url = `https://api.copomex.com/query/info_cp/${this.value}?token=46556d12-eb2c-4cf1-acf6-0a2576978306`;

            const response = await fetch(url);
            const data = await response.json();

            const select = document.getElementById("colonia_input");
            data.forEach(item => {

                const asentamiento = item.response.asentamiento;

                const option = document.createElement("option");

                document.getElementById("state_input").value = data[0].response.estado;
                document.getElementById("city_input").value = data[0].response.ciudad;
                document.getElementById("country_input").value = data[0].response.pais;
                option.value = asentamiento;
                option.textContent = asentamiento;

                select.appendChild(option);

            });

            console.log(data);

        }

    });

});

document.getElementById("save-client").addEventListener("submit", async function(e){

    e.preventDefault();

    const form = this;
    const formData = new FormData(form);

    // validar campos vacíos
    for (let [name, value] of formData.entries()) {

        if (!value.trim()) {
            alert("El campo " + name + " está vacío");
            return;
        }

    }

    try {

        const response = await fetch("/api/create-clients", {
            method: "POST",
            body: formData
        });

        const data = await response.json();

        console.log(data);

        alert("Cliente creado correctamente");

        form.reset();

    } catch (error) {

        console.error(error);
        alert("Error al guardar");

    }

});





</script>
@endsection