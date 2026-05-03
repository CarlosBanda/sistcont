@extends('template.index')

@section('content')
<style>
.resultados {
    position: absolute;
    z-index: 1000;
    width: 100%;
}

.item-producto:hover{
    background:#f1f1f1;
    cursor:pointer;
}
</style>

 <div class="card">
  <div class="card-body">

    <h4 class="card-title text-info">Nueva nota de venta</h4>

    <div class="row mt-4">

      <div class="col-md-6">

        <div class="row">
               {{-- <div class="col-md-6">
               <div class="form-group">
                    <label>Serie</label>
                    <input type="text" id="serie" name="serie" class="form-control">
               </div>
               </div> --}}

               <div class="col-md-6">
               <div class="form-group">
                    <label>Folio</label>
                    <input type="text" id="folio" name="folio" class="form-control" readonly>
                    <div class="mt-3">
                         <button type="button" class="btn btn-gradient mt-2 fw-semibold" onclick="generateFolio('NV')">
                             <i class="bi bi-file-earmark-text"></i>
                              Generar Folio
                         </button>
                    </div>
               </div>
               </div>
          </div>


        <div class="form-group mb-3">
          <label>Cliente</label>
          <div class="d-flex">
            <select class="form-control me-2">
              <option value="">Seleccionar cliente</option>
              @foreach($clientes as $cliente)
                <option value="{{ $cliente->id }}">{{ $cliente->name }}</option>
              @endforeach
            </select>
          </div>
        </div>

        <div class="form-group">
          <label>Fecha de elaboración</label>
          <input type="date" class="form-control">
        </div>

      </div>

      <div class="col-md-6">


        <div class="form-group">
          <label>Vendedor</label>
          <select class="form-control me-2">
              <option value="">Seleccionar vendedor</option>
              @foreach($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }}</option>
              @endforeach
            </select>
        </div>

      </div>

    </div>

    <div class="table-responsive mt-4">
      <table class="table table-bordered align-middle text-center">
        <thead class="table-light">
          <tr>
            <th>#</th>
            <th>Producto</th>
            <th>Descripción</th>
            <th>Almacén</th>
            <th>Cant</th>
            <th>Valor Unitario</th>
            <th>% Desc.</th>
            <th>Impuesto</th>
            <th>Valor Total</th>
            <th></th>
          </tr>
        </thead>

        <tbody id="products-table">
          <tr>
            <td>1</td>

            <td>
              <input type="text" class="form-control buscar-producto" placeholder="Buscar producto...">
              <div class="list-group resultados"></div>
            </td>

            <td>
              <input type="text" class="form-control">
            </td>

            <td>
              <input type="text" class="form-control">
            </td>

            <td>
              <input type="number" class="form-control" value="1">
            </td>

            <td>
              <input type="number" class="form-control" value="0.00">
            </td>

            <td>
              <input type="number" class="form-control" value="0">
            </td>

            <td>
              <input type="number" class="form-control" value="0.00">
            </td>

            <td>
              <input type="number" class="form-control" value="0.00" readonly>
            </td>

            <td>
              <button class="btn btn-danger btn-sm eliminar-fila">🗑</button>
            </td>

          </tr>
        </tbody>
      </table>
    </div>

    <div class="text-end mt-3">
      <button class="btn btn-primary">Guardar venta</button>
    </div>

  </div>
</div>


<script>

let productos = [];

// BUSCAR PRODUCTO EN ESA FILA
document.addEventListener('keyup', function(e){

    if(e.target.classList.contains('buscar-producto')){

        let input = e.target;
        let texto = input.value;
        let contenedor = input.nextElementSibling;

        if(texto.length < 2){
            contenedor.innerHTML = '';
            return;
        }

        fetch('/buscar-producto?texto=' + texto)
        .then(res => res.json())
        .then(data => {

            productos = data;

            let html = '';

            data.forEach((p,i)=>{
                html += `
                <a class="list-group-item item-producto" data-index="${i}">
                    ${p.code} - ${p.name}
                    <span class="float-end">$${p.price}</span>
                </a>`;
            });

            contenedor.innerHTML = html;
        });
    }

});


// SELECCIONAR PRODUCTO
document.addEventListener('click', function(e){

    if(e.target.classList.contains('item-producto')){

        let index = e.target.getAttribute('data-index');
        let producto = productos[index];

        let fila = e.target.closest('tr');

        // LLENAR CAMPOS
        fila.querySelector('.buscar-producto').value = producto.code;
        fila.children[2].querySelector('input').value = producto.description ?? producto.name;
        fila.children[4].querySelector('input').value = 1;
        fila.children[5].querySelector('input').value = producto.price;

        // CALCULAR TOTAL
        calcularFila(fila);

        // LIMPIAR RESULTADOS
        e.target.parentElement.innerHTML = '';

        // AGREGAR NUEVA FILA AUTOMÁTICAMENTE
        agregarNuevaFila();
    }

});


// CALCULAR TOTAL
function calcularFila(fila){

    let cant = parseFloat(fila.children[4].querySelector('input').value) || 0;
    let precio = parseFloat(fila.children[5].querySelector('input').value) || 0;
    let desc = parseFloat(fila.children[6].querySelector('input').value) || 0;

    let total = (cant * precio) - desc;

    fila.children[8].querySelector('input').value = total.toFixed(2);
}


// CAMBIO EN CANTIDAD / PRECIO / DESCUENTO
document.addEventListener('input', function(e){

    if(e.target.closest('tr')){
        let fila = e.target.closest('tr');
        calcularFila(fila);
    }

});




// agregar fila de producto
function agregarNuevaFila(){

    let tabla = document.getElementById('products-table');
    let filas = tabla.querySelectorAll('tr');
    let numero = filas.length + 1;

    let nuevaFila = `
    <tr>
        <td>${numero}</td>

        <td style="position:relative;">
            <input type="text" class="form-control buscar-producto" placeholder="Buscar producto...">
            <div class="list-group resultados"></div>
        </td>

        <td><input type="text" class="form-control"></td>
        <td><input type="text" class="form-control"></td>

        <td><input type="number" class="form-control" value="1"></td>
        <td><input type="number" class="form-control" value="0.00"></td>
        <td><input type="number" class="form-control" value="0"></td>
        <td><input type="number" class="form-control" value="0.00"></td>

        <td><input type="number" class="form-control" value="0.00" readonly></td>

        <td>
            <button class="btn btn-danger btn-sm eliminar-fila">🗑</button>
        </td>
    </tr>
    `;

    tabla.insertAdjacentHTML('beforeend', nuevaFila);

    // enfocar automáticamente el nuevo input
    let ultimaFila = tabla.lastElementChild;
    ultimaFila.querySelector('.buscar-producto').focus();
}


document.addEventListener('click', function(e){

    const boton = e.target.closest('.eliminar-fila');

    if(!boton) return;

    const fila = boton.closest('tr');

    fila.remove();

    recalcularNumeros();

});

function recalcularNumeros(){

    let filas = document.querySelectorAll('#products-table tr');

    filas.forEach((fila, index) => {
        fila.children[0].innerText = index + 1;
    });

}
</script>
@endsection