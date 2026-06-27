@extends('template.index')

@section('content')
<style>
.resultados {
    position: absolute;
    z-index: 1000;
    width: 100%;
    max-height: 260px;
    overflow-y: auto;
}

.item-producto:hover {
    background: #f1f1f1;
    cursor: pointer;
}

.product-cell {
    min-width: 260px;
    position: relative;
}

.barcode-list {
    min-width: 220px;
    min-height: 74px;
    resize: vertical;
    font-size: 12px;
}

.sale-summary {
    max-width: 360px;
    margin-left: auto;
}

.sale-summary .row {
    margin-bottom: 8px;
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
            <select id="client_id" class="form-control me-2" name="client_id">
              <option value="">Seleccionar cliente</option>
              @foreach($clientes as $cliente)
                <option value="{{ $cliente->id }}">{{ $cliente->name }}</option>
              @endforeach
            </select>
          </div>
        </div>

        <div class="form-group">
          <label>Fecha de elaboracion</label>
          <input type="date" id="sale_date" class="form-control" name="sale_date">
        </div>

      </div>

      <div class="col-md-6">


        <div class="form-group">
          <label>Vendedor</label>
          <select id="user_id" class="form-control me-2" name="user_id">
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
            <th>Descripcion</th>
            <th>Codigos de barra</th>
            <th>Cant</th>
            <th>Valor Unitario</th>
            <th>% Desc.</th>
            <th>IVA</th>
            <th>Valor Total</th>
            <th></th>
          </tr>
        </thead>

        <tbody id="products-table"></tbody>
      </table>
    </div>

    <div class="sale-summary mt-3">
      <div class="row align-items-center">
        <div class="col-6 text-end fw-semibold">Subtotal</div>
        <div class="col-6"><input type="text" id="summary-subtotal" class="form-control text-end" value="0.00" readonly></div>
      </div>
      <div class="row align-items-center">
        <div class="col-6 text-end fw-semibold">Descuento</div>
        <div class="col-6"><input type="text" id="summary-discount" class="form-control text-end" value="0.00" readonly></div>
      </div>
      <div class="row align-items-center">
        <div class="col-6 text-end fw-semibold">IVA</div>
        <div class="col-6"><input type="text" id="summary-tax" class="form-control text-end" value="0.00" readonly></div>
      </div>
      <div class="row align-items-center">
        <div class="col-6 text-end fw-bold">Total</div>
        <div class="col-6"><input type="text" id="summary-total" class="form-control text-end fw-bold" value="0.00" readonly></div>
      </div>
    </div>

    <div class="text-end mt-3">
      <button type="button" id="save-sale" class="btn btn-primary">Guardar venta</button>
    </div>

  </div>
</div>

<script>
const productosPorFila = new WeakMap();
let searchTimer = null;

function generateFolio(type) {
    apiFetch(`next-folio?type=${type}`)
        .then(data => {
            document.getElementById('folio').value = data.folio;
        })
        .catch(() => {
            Swal.fire({
                icon: 'error',
                title: 'Error al generar el folio'
            });
        });
}

function money(value) {
    return (Number(value) || 0).toFixed(2);
}

function escapeHtml(value) {
    return String(value ?? '')
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#039;');
}

function crearFila(numero) {
    return `
    <tr>
        <td class="row-number">${numero}</td>
        <td class="product-cell">
            <input type="hidden" class="product-id" name="products[${numero - 1}][product_id]">
            <input type="text" class="form-control buscar-producto" placeholder="Buscar producto, modelo o codigo..." autocomplete="off">
            <div class="list-group resultados"></div>
            <small class="text-muted product-stock d-block mt-1">Sin producto seleccionado</small>
        </td>
        <td><input type="text" class="form-control description" name="products[${numero - 1}][description]"></td>
        <td>
            <textarea class="form-control barcode-list" readonly></textarea>
            <input type="hidden" class="inventory-ids" name="products[${numero - 1}][inventory_ids]">
            <small class="text-danger stock-warning d-none">No hay codigos suficientes para esa cantidad.</small>
        </td>
        <td><input type="number" class="form-control qty" name="products[${numero - 1}][qty]" value="1" min="0" step="1"></td>
        <td><input type="number" class="form-control unit-price" name="products[${numero - 1}][price]" value="0.00" min="0" step="0.01"></td>
        <td><input type="number" class="form-control discount" name="products[${numero - 1}][discount]" value="0" min="0" max="100" step="0.01"></td>
        <td>
            <select class="form-control tax-rate" name="products[${numero - 1}][tax]">
                <option value="0">Sin IVA</option>
                <option value="16">IVA 16%</option>
            </select>
        </td>
        <td><input type="number" class="form-control total" name="products[${numero - 1}][total]" value="0.00" readonly></td>
        <td>
            <button type="button" class="btn btn-danger btn-sm eliminar-fila"><i class="bi bi-trash"></i></button>
        </td>
    </tr>`;
}

function agregarNuevaFila(enfocar = true) {
    const tabla = document.getElementById('products-table');
    const numero = tabla.querySelectorAll('tr').length + 1;

    tabla.insertAdjacentHTML('beforeend', crearFila(numero));

    const ultimaFila = tabla.lastElementChild;
    productosPorFila.set(ultimaFila, []);

    if (enfocar) {
        ultimaFila.querySelector('.buscar-producto').focus();
    }
}

function buscarProducto(input) {
    const texto = input.value.trim();
    const fila = input.closest('tr');
    const contenedor = fila.querySelector('.resultados');

    if (texto.length < 2) {
        contenedor.innerHTML = '';
        productosPorFila.set(fila, []);
        return;
    }

    fetch('/buscar-producto?texto=' + encodeURIComponent(texto))
        .then(res => res.json())
        .then(data => {
            productosPorFila.set(fila, data);

            if (!data.length) {
                contenedor.innerHTML = '<div class="list-group-item text-muted">Sin resultados</div>';
                return;
            }

            contenedor.innerHTML = data.map((p, i) => `
                <button type="button" class="list-group-item list-group-item-action item-producto" data-index="${i}">
                    <span class="d-block fw-semibold">${escapeHtml(p.code || 'Sin modelo')} - ${escapeHtml(p.name)}</span>
                    <small>Stock: ${p.stock} | Precio: $${money(p.price)}</small>
                </button>
            `).join('');
        })
        .catch(() => {
            contenedor.innerHTML = '<div class="list-group-item text-danger">Error al buscar productos</div>';
        });
}

document.addEventListener('keyup', function(e) {
    if (!e.target.classList.contains('buscar-producto')) return;

    clearTimeout(searchTimer);
    const input = e.target;
    searchTimer = setTimeout(() => buscarProducto(input), 250);
});

document.addEventListener('click', function(e) {
    const item = e.target.closest('.item-producto');

    if (!item) return;

    const fila = item.closest('tr');
    const productos = productosPorFila.get(fila) || [];
    const producto = productos[Number(item.dataset.index)];

    if (!producto) return;

    fila.dataset.barcodes = JSON.stringify(producto.barcodes || []);
    fila.dataset.inventoryIds = JSON.stringify(producto.inventory_ids || []);
    fila.dataset.stock = producto.stock || 0;

    fila.querySelector('.product-id').value = producto.id;
    fila.querySelector('.buscar-producto').value = producto.code || producto.name;
    fila.querySelector('.description').value = producto.description || producto.name;
    fila.querySelector('.unit-price').value = money(producto.price);
    fila.querySelector('.qty').value = producto.stock > 0 ? 1 : 0;
    fila.querySelector('.qty').max = producto.stock || 0;
    fila.querySelector('.product-stock').textContent = `Disponibles: ${producto.stock}`;
    fila.querySelector('.resultados').innerHTML = '';

    actualizarCodigos(fila);
    calcularFila(fila);

    const esUltimaFila = fila === document.querySelector('#products-table tr:last-child');
    if (esUltimaFila) {
        agregarNuevaFila();
    }
});

document.addEventListener('input', function(e) {
    const fila = e.target.closest('#products-table tr');
    if (!fila) return;

    if (e.target.classList.contains('qty')) {
        actualizarCodigos(fila);
    }

    if (e.target.matches('.qty, .unit-price, .discount')) {
        calcularFila(fila);
    }
});

document.addEventListener('change', function(e) {
    if (!e.target.classList.contains('tax-rate')) return;

    const fila = e.target.closest('tr');
    calcularFila(fila);
});

document.addEventListener('click', function(e) {
    const boton = e.target.closest('.eliminar-fila');
    if (!boton) return;

    const filas = document.querySelectorAll('#products-table tr');
    if (filas.length === 1) {
        limpiarFila(filas[0]);
        return;
    }

    boton.closest('tr').remove();
    recalcularNumeros();
    recalcularTotales();
});

function actualizarCodigos(fila) {
    const qtyInput = fila.querySelector('.qty');
    const cantidad = Math.max(parseInt(qtyInput.value, 10) || 0, 0);
    const stock = Number(fila.dataset.stock || 0);
    const barcodes = JSON.parse(fila.dataset.barcodes || '[]');
    const inventoryIds = JSON.parse(fila.dataset.inventoryIds || '[]');
    const warning = fila.querySelector('.stock-warning');

    if (cantidad > stock) {
        warning.classList.remove('d-none');
    } else {
        warning.classList.add('d-none');
    }

    const seleccionados = barcodes.slice(0, cantidad);
    const inventariosSeleccionados = inventoryIds.slice(0, cantidad);

    fila.querySelector('.barcode-list').value = seleccionados.join('\n');
    fila.querySelector('.inventory-ids').value = inventariosSeleccionados.join(',');
}

function calcularFila(fila) {
    const cantidad = Math.max(parseFloat(fila.querySelector('.qty').value) || 0, 0);
    const precio = Math.max(parseFloat(fila.querySelector('.unit-price').value) || 0, 0);
    const descuentoPorcentaje = Math.min(Math.max(parseFloat(fila.querySelector('.discount').value) || 0, 0), 100);
    const ivaPorcentaje = Math.max(parseFloat(fila.querySelector('.tax-rate').value) || 0, 0);

    const subtotal = cantidad * precio;
    const descuento = subtotal * (descuentoPorcentaje / 100);
    const base = subtotal - descuento;
    const iva = base * (ivaPorcentaje / 100);
    const total = base + iva;

    fila.dataset.subtotal = subtotal;
    fila.dataset.discountAmount = descuento;
    fila.dataset.taxAmount = iva;
    fila.dataset.total = total;

    fila.querySelector('.total').value = money(total);
    recalcularTotales();
}

function recalcularTotales() {
    let subtotal = 0;
    let descuento = 0;
    let iva = 0;
    let total = 0;

    document.querySelectorAll('#products-table tr').forEach(fila => {
        subtotal += Number(fila.dataset.subtotal || 0);
        descuento += Number(fila.dataset.discountAmount || 0);
        iva += Number(fila.dataset.taxAmount || 0);
        total += Number(fila.dataset.total || 0);
    });

    document.getElementById('summary-subtotal').value = money(subtotal);
    document.getElementById('summary-discount').value = money(descuento);
    document.getElementById('summary-tax').value = money(iva);
    document.getElementById('summary-total').value = money(total);
}

function limpiarFila(fila) {
    fila.removeAttribute('data-barcodes');
    fila.removeAttribute('data-inventory-ids');
    fila.removeAttribute('data-stock');
    fila.querySelectorAll('input, textarea').forEach(input => {
        if (input.classList.contains('qty')) {
            input.value = 1;
            return;
        }

        if (input.classList.contains('unit-price') || input.classList.contains('total')) {
            input.value = '0.00';
            return;
        }

        if (input.classList.contains('discount')) {
            input.value = 0;
            return;
        }

        input.value = '';
    });
    fila.querySelector('.tax-rate').value = 0;
    fila.querySelector('.product-stock').textContent = 'Sin producto seleccionado';
    fila.querySelector('.stock-warning').classList.add('d-none');
    fila.querySelector('.resultados').innerHTML = '';
    calcularFila(fila);
}


function obtenerProductosVenta() {
    const products = [];

    document.querySelectorAll('#products-table tr').forEach(fila => {
        const productId = fila.querySelector('.product-id').value;
        const qty = parseInt(fila.querySelector('.qty').value, 10) || 0;

        if (!productId || qty <= 0) return;

        const inventoryIds = fila.querySelector('.inventory-ids').value
            .split(',')
            .map(id => Number(id))
            .filter(Boolean);

        products.push({
            product_id: Number(productId),
            qty: qty,
            price: Number(fila.querySelector('.unit-price').value) || 0,
            discount: Number(fila.querySelector('.discount').value) || 0,
            tax: Number(fila.querySelector('.tax-rate').value) || 0,
            inventory_ids: inventoryIds,
        });
    });

    return products;
}

function validarVenta(products) {
    if (!document.getElementById('client_id').value) {
        return 'Selecciona un cliente.';
    }

    if (!document.getElementById('user_id').value) {
        return 'Selecciona un vendedor.';
    }

    if (!products.length) {
        return 'Agrega al menos un producto a la venta.';
    }

    const productoSinCodigos = products.find(product => product.inventory_ids.length !== product.qty);
    if (productoSinCodigos) {
        return 'La cantidad debe coincidir con los codigos de barra disponibles por producto.';
    }

    return null;
}

document.getElementById('save-sale').addEventListener('click', async function() {
    const button = this;
    const products = obtenerProductosVenta();
    const error = validarVenta(products);

    if (error) {
        Swal.fire({
            icon: 'warning',
            title: error
        });
        return;
    }

    button.disabled = true;

    try {
        const response = await apiFetch('create-sale', {
            method: 'POST',
            body: JSON.stringify({
                folio: document.getElementById('folio').value,
                client_id: document.getElementById('client_id').value,
                user_id: document.getElementById('user_id').value,
                sale_date: document.getElementById('sale_date').value,
                currency: 'MXN',
                products: products,
            })
        });

        if (response?.success) {
            Swal.fire({
                icon: 'success',
                title: 'Venta guardada correctamente',
                text: response.sale?.folio?.folio || ''
            });

            setTimeout(() => window.location.reload(), 1400);
            return;
        }

        Swal.fire({
            icon: 'error',
            title: 'Error al guardar la venta',
            text: response?.message || 'Revisa los datos e intenta nuevamente.'
        });
    } catch (error) {
        Swal.fire({
            icon: 'error',
            title: 'Error al guardar la venta',
            text: 'No se pudo completar la solicitud.'
        });
    } finally {
        button.disabled = false;
    }
});

function recalcularNumeros() {
    document.querySelectorAll('#products-table tr').forEach((fila, index) => {
        const numero = index + 1;
        fila.querySelector('.row-number').innerText = numero;
        fila.querySelectorAll('[name^="products["]').forEach(input => {
            input.name = input.name.replace(/products\[\d+\]/, `products[${index}]`);
        });
    });
}

agregarNuevaFila(false);

document.addEventListener('DOMContentLoaded', () => {

    let data = localStorage.getItem('quotationToSale');

    if(!data) return;

    let quotation = JSON.parse(data);
    console.log("QUOTATION TO SALE", quotation);


    document.getElementById('client_id').value = quotation.client_id;
    document.getElementById('user_id').value = quotation.user_id;
    document.getElementById('sale_date').value = quotation.quotation_date;

    let table = document.getElementById('products-table');
    table.innerHTML = '';

    quotation.items.forEach((item, index) => {
    // console.log("ITEM",item);

        agregarNuevaFila(false);

        let row = table.rows[index];

        row.querySelector('.product-id').value = item.product_id;
        row.querySelector('.buscar-producto').value = item.product?.nombre || '';
        row.querySelector('.description').value = item.product?.modelo || '';

        row.querySelector('.qty').value = item.qty;
        row.querySelector('.unit-price').value = item.price;
        row.querySelector('.discount').value = item.discount || 0;

        row.dataset.barcodes = JSON.stringify(
            Array(item.qty).fill(item.barcode)
        );

        row.dataset.inventoryIds = JSON.stringify([]);
        row.dataset.stock = item.qty;

        actualizarCodigos(row);

        let taxValue = parseFloat(item.tax) * 100 || 0;
        row.querySelector('.tax-rate').value = taxValue;

        calcularFila(row);
    });

    recalcularTotales();

    localStorage.removeItem('quotationToSale');
});

</script>
@endsection
