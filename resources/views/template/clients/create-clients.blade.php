@extends('template.index')

@section('content')
    <div class="row">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Crear Cliente</h4>
                <form id="save-client" class="form-sample">

                    <!-- Tipo de persona (controla qué campos se muestran) -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Tipo</label>
                                <div class="col-sm-9">
                                    <select id="type_person" name="tax_regime" class="form-control">
                                        <option value="fisica">Persona Física</option>
                                        <option value="moral">Persona Moral</option>
                                        <option value="otro">Otro</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">RFC</label>
                                <div class="col-sm-9">
                                    <input id="rfc_input_field" name="rfc" type="text" class="form-control" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Campos para Persona Física -->
                    <div id="campos-fisica" class="row">
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

                    <!-- Campos para Persona Moral -->
                    <div id="campos-moral" class="row" style="display: none;">
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Razón Social / Nombre de Empresa</label>
                                <div class="col-sm-10">
                                    <input id="razon_social_input" name="razon_social" type="text" class="form-control" />
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
                                <label class="col-sm-3 col-form-label">Código postal</label>
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
                                <label class="col-sm-3 col-form-label">Dirección</label>
                                <div class="col-sm-9">
                                    <input id="address" type="text" name="address" class="form-control" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">País</label>
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
                    <button type="submit" class="btn btn-primary mr-2">Guardar</button>

                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
     <script src="{{ asset('js/clientPostalCode.js') }}"></script>
     <script src="{{ asset('js/addClients.js') }}"></script>
@endsection
