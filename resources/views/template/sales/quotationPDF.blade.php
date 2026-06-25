<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Cotización</title>

    <style>
        body{
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        .header{
            text-align: center;
            border-bottom: 1px solid #000;
            padding-bottom: 10px;
        }
        .box{
            border:1px solid #000;
            padding:10px;
            margin-top:10px;
        }
        table{
            width:100%;
            border-collapse: collapse;
            margin-top:10px;
        }
        table, th, td{
            border:1px solid #000;
        }
        th, td{
            padding:5px;
            text-align:center;
        }
    </style>
</head>

<body>

<div class="header">
    <h3>COTIZACIÓN</h3>
    <p>No. Folio: {{$quotation->folio->folio}}</p>
    <p>Fecha: {{$quotation->quotation_date}}</p>
</div>

<div class="box">
    <strong>Cliente:</strong> {{ $quotation->client->name}} <br>
    <strong>RFC:</strong> {{ $quotation->client->rfc}}
</div>

<table>
    <thead>
        <tr>
            <th>Item</th>
            <th>Producto</th>
            <th>Descripción</th>
            <th>Cantidad</th>
            <th>Precio</th>
            <th>Total</th>
        </tr>
    </thead>

    <tbody>
        @forelse($quotation->items as $index => $item)
        <tr>
            <td>{{$index + 1}}</td>
            <td>{{$item->product->nombre ?? ''}}</td>
            <td>{{$item->product->modelo ?? ''}}</td>
            <td>{{$item->qty}}</td>
            <td>{{number_format($item->price, 2)}}</td>
            <td>{{number_format($item->total, 2)}}</td>
        </tr>
        @empty
        <tr>
            <td colspan="6">Sin productos</td>
        </tr>
        @endforelse
    </tbody>
</table>

<div class="box">
    <p>Subtotal: ${{ number_format($quotation->subtotal, 2) }}</p>
    <p>Descuento: ${{ number_format($quotation->discount, 2) }}</p>
    <p>IVA: ${{ number_format($quotation->tax, 2) }}</p>
    <p><strong>Total: ${{ number_format($quotation->total, 2) }}</strong></p>
</div>

</body>
</html>