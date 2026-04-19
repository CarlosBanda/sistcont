@extends('template.index')

@section('content')

<div class="main-panel">
        <div class="content-wrapper">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Clientes</h4>
                  <div class="table-responsive">
                    <table class="table">
                      <thead>
                        <tr>
                          <th>Nombre</th>
                          <th>Direccion</th>
                          <th>Telefono</th>
                          <th>RFC</th>
                        </tr>
                      </thead>
                      <tbody>
                        {{-- @foreach($clientes as $cliente)
                          <tr>
                            <td>{{$cliente->name}}</td>
                            <td>{{$cliente->address}}</td>
                            <td>{{$cliente->phone}}</td>
                            <td>{{$cliente->rfc}}</td>
                            <td><button id="{{$cliente->id}}" type="button" class="btn btn-success">Info</button></td>
                          </tr>
                        @endforeach --}}
                      </tbody>
                    </table>
                  </div>
                </div>
          </div>
        </div>
@endsection
@section('scripts')
     <script src="{{ asset('js/clients.js') }}"></script>
@endsection