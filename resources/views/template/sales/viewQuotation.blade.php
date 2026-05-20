@extends('template.index')

@section('content')
<div class="card">
    <div class="card-body">

        <h4 class="card-title mb-4">Cotizaciones</h4>

        <div class="mb-4">
            <input 
                type="text" 
                id="search-folio" 
                class="form-control form-control-lg" 
                placeholder="Buscar por folio">
        </div>

        <div class="table-responsive">
            <table class="table table-bordered text-center align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Folio</th>
                        <th>Cliente</th>
                        <th>Contacto</th>
                        <th>Fecha</th>
                        <th>Moneda</th>
                    </tr>
                </thead>

                <tbody id="quotations-table">

                </tbody>
            </table>
        </div>

    </div>
</div>
@endsection
@section('scripts')
     <script src="{{ asset('js/quotations-list.js') }}"></script>
@endsection