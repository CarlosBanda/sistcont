@extends('template.index')

@section('content')
    <div class="row">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Crear Usuarios</h4>
                <form id="save-user" class="form-sample">

                    <div class="row">
                        <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Nombres</label>
                            <div class="col-sm-9">
                            <input id="name_user" name="name_user" type="text" class="form-control" />
                            </div>
                        </div>
                        </div>
                        <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Apellidos</label>
                            <div class="col-sm-9">
                                <input id="lastname_user" name="lastname_user" type="text" class="form-control" />
                            </div>
                        </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Correo Electrónico</label>
                            <div class="col-sm-9">
                                <input id="email_user" name="email_user" type="email" class="form-control" />
                            </div>
                        </div>
                        </div>
                        <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Password</label>
                            <div class="col-sm-9">
                                <input id="password_user" name="password_user" type="password" class="form-control" />
                            </div>
                        </div>
                        </div>
                    </div>

                    <div class="mt-3 text-end">
                         <button type="submit"  class="btn btn-primary mr-2">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/addUsers.js') }}"></script>
@endsection