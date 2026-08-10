/**
 * Dashboard Widgets
 * 
 * Script encargado de consumir la API de estadísticas del dashboard
 * y renderizar las gráficas con Chart.js.
 * 
 * Widgets:
 * 1. Cards de resumen (ventas del mes, clientes, productos, cotizaciones)
 * 2. Gráfica de barras - Ventas mensuales (últimos 6 meses)
 * 3. Gráfica de dona - Distribución de estatus del inventario
 * 4. Barras horizontales - Top 5 productos más vendidos
 */

document.addEventListener('DOMContentLoaded', function() {
    loadDashboard();
});

/**
 * Función principal que consume el endpoint y distribuye los datos
 * a cada función de renderizado.
 */
function loadDashboard() {
    apiFetch('dashboard-stats').then(data => {
        if (!data) return;

        renderCards(data.cards);
        renderVentasMensuales(data.ventas_mensuales);
        renderInventario(data.estatus_inventario);
        renderTopProductos(data.top_productos);
    }).catch(err => {
        console.error('Error al cargar dashboard:', err);
    });
}

// ─── Cards de Resumen ─────────────────────────────────────────────

/**
 * Actualiza el texto de las 4 tarjetas de resumen con los valores
 * recibidos de la API.
 * 
 * @param {Object} cards - { ventas_mes, total_clientes, total_productos, cotizaciones_mes }
 */
function renderCards(cards) {
    document.getElementById('card-ventas-mes').textContent = '$' + formatNumber(cards.ventas_mes);
    document.getElementById('card-clientes').textContent = cards.total_clientes;
    document.getElementById('card-productos').textContent = cards.total_productos;
    document.getElementById('card-cotizaciones').textContent = cards.cotizaciones_mes;
}

// ─── Ventas Mensuales (Barras) ────────────────────────────────────

/**
 * Renderiza una gráfica de barras verticales mostrando el total
 * de ventas por cada uno de los últimos 6 meses.
 * 
 * @param {Array} ventas - [{ mes: "Ago 2026", total: 15000.50 }, ...]
 */
function renderVentasMensuales(ventas) {
    const ctx = document.getElementById('chartVentasMensuales').getContext('2d');
    
    const labels = ventas.map(v => v.mes);
    const datos = ventas.map(v => v.total);

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Ventas ($)',
                data: datos,
                backgroundColor: 'rgba(102, 126, 234, 0.7)',
                borderColor: 'rgba(102, 126, 234, 1)',
                borderWidth: 1,
                borderRadius: 4,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        // Formatear el eje Y con signo de pesos
                        callback: function(value) {
                            return '$' + formatNumber(value);
                        }
                    }
                }
            }
        }
    });
}

// ─── Estatus de Inventario (Dona) ─────────────────────────────────

/**
 * Renderiza una gráfica de dona (doughnut) con la distribución
 * de los estatus del inventario (disponible, vendido, etc.).
 * También llena una tabla HTML con los mismos datos.
 * 
 * @param {Array} inventario - [{ estatus: "disponible", cantidad: 25 }, ...]
 */
function renderInventario(inventario) {
    const ctx = document.getElementById('chartInventario').getContext('2d');

    const labels = inventario.map(i => capitalize(i.estatus));
    const datos = inventario.map(i => i.cantidad);

    // Mapa de colores por estatus
    const colores = {
        'Disponible': '#43e97b',
        'Vendido': '#f5576c',
        'Garantia': '#ffc107',
        'Dañado': '#6c757d',
    };

    const backgroundColors = labels.map(label => colores[label] || '#4facfe');

    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: labels,
            datasets: [{
                data: datos,
                backgroundColor: backgroundColors,
                borderWidth: 2,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                }
            }
        }
    });

    // Llenar tabla auxiliar de inventario
    const tbody = document.querySelector('#tablaInventario tbody');
    tbody.innerHTML = '';
    inventario.forEach(item => {
        tbody.innerHTML += `
            <tr>
                <td><span class="badge" style="background-color: ${colores[capitalize(item.estatus)] || '#4facfe'}; color: #fff;">${capitalize(item.estatus)}</span></td>
                <td>${item.cantidad}</td>
            </tr>
        `;
    });
}

// ─── Top 5 Productos (Barras Horizontales) ────────────────────────

/**
 * Renderiza una gráfica de barras horizontales con los 5 productos
 * más vendidos, ordenados por cantidad de unidades.
 * 
 * @param {Array} productos - [{ nombre: "Laptop HP", total_vendido: 12 }, ...]
 */
function renderTopProductos(productos) {
    const ctx = document.getElementById('chartTopProductos').getContext('2d');

    const labels = productos.map(p => p.nombre);
    const datos = productos.map(p => p.total_vendido);

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Unidades vendidas',
                data: datos,
                backgroundColor: [
                    'rgba(245, 87, 108, 0.7)',
                    'rgba(79, 172, 254, 0.7)',
                    'rgba(67, 233, 123, 0.7)',
                    'rgba(240, 147, 251, 0.7)',
                    'rgba(255, 193, 7, 0.7)',
                ],
                borderColor: [
                    'rgba(245, 87, 108, 1)',
                    'rgba(79, 172, 254, 1)',
                    'rgba(67, 233, 123, 1)',
                    'rgba(240, 147, 251, 1)',
                    'rgba(255, 193, 7, 1)',
                ],
                borderWidth: 1,
                borderRadius: 4,
            }]
        },
        options: {
            indexAxis: 'y', // Barras horizontales
            responsive: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                x: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1 // Solo números enteros
                    }
                }
            }
        }
    });
}

// ─── Funciones Utilitarias ────────────────────────────────────────

/**
 * Formatear número con separador de miles y 2 decimales (formato MX).
 * Ejemplo: 15000.5 → "15,000.50"
 * 
 * @param {number} num Número a formatear
 * @returns {string} Número formateado
 */
function formatNumber(num) {
    return Number(num).toLocaleString('es-MX', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
}

/**
 * Capitalizar la primera letra de un string.
 * Ejemplo: "disponible" → "Disponible"
 * 
 * @param {string} str Texto a capitalizar
 * @returns {string} Texto con primera letra mayúscula
 */
function capitalize(str) {
    if (!str) return '';
    return str.charAt(0).toUpperCase() + str.slice(1);
}
