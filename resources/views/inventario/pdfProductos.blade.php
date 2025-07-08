<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Productos</title>
    <style>
        @page {
            size: A4 landscape;
            margin: 0.5cm;
        }
        body { 
            font-family: Arial, sans-serif; 
            margin: 0;
            padding: 10px;
            font-size: 8px;
        }
        .header { 
            text-align: center; 
            margin-bottom: 10px;
            padding-bottom: 5px;
            border-bottom: 1px solid #eee;
        }
        h1 {
            font-size: 16px;
            margin: 5px 0;
        }
        .header p {
            margin: 0;
            font-size: 10px;
            color: #666;
        }
        table {
            width: 100%; 
            border-collapse: collapse;
            margin-top: 5px;
            table-layout: fixed;
            page-break-inside: auto;
        }
        th, td { 
            border: 1px solid #ddd; 
            padding: 4px; 
            text-align: left;
            word-wrap: break-word;
            line-height: 1.2;
        }
        th { 
            background-color: #f2f2f2; 
            font-size: 9px;
            position: sticky;
            top: 0;
        }
        td {
            font-size: 8px;
            vertical-align: top;
        }
        .badge {
            padding: 2px 4px;
            border-radius: 2px;
            font-size: 8px;
            color: white;
            display: inline-block;
            min-width: 40px;
            text-align: center;
        }
        .active { background-color: #28a745; }
        .inactive { background-color: #dc3545; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        tr:nth-child(even) { background-color: #f9f9f9; }
        .nowrap { white-space: nowrap; }
        
        @media print {
            body {
                font-size: 7pt;
            }
            table {
                page-break-inside: avoid;
            }
            th, td {
                padding: 3px;
                font-size: 7pt;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Listado de Productos</h1>
        <p>Generado el: {{ now()->format('d/m/Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="3%">N°</th>
                <th width="12%">Nombre</th>
                <th width="10%">Descripción</th>
                <th width="8%">Cód Barras</th>
                <th width="8%">Cód Interno</th>
                <th width="6%" class="text-right nowrap">P. Compra</th>
                <th width="6%" class="text-right nowrap">P. Venta</th>
                <th width="4%" class="text-center">Stock</th>
                <th width="5%" class="text-center">Stock Min</th>
                <th width="8%">Categoría</th>
                <th width="8%">Proveedor</th>
                <th width="5%">Unidad</th>
                <th width="5%" class="text-center">Estado</th>
                <th width="4%" class="text-center">Img</th>
                <th width="7%" class="nowrap">Últ. Venta</th>
                <th width="7%" class="nowrap">Caducidad</th>
            </tr>
        </thead>
        <tbody>
            @foreach($productos as $index => $producto)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $producto->nombre }}</td>
                <td>{{ Str::limit($producto->descripcion, 20) }}</td>
                <td>{{ $producto->codigo_barras }}</td>
                <td>{{ $producto->codigo_interno }}</td>
                <td class="text-right nowrap">{{ number_format($producto->precio_compra, 2) }}</td>
                <td class="text-right nowrap">{{ number_format($producto->precio_venta, 2) }}</td>
                <td class="text-center">{{ $producto->stock }}</td>
                <td class="text-center">{{ $producto->stock_minimo }}</td>
                <td>{{ $producto->categoria->nombre ?? $producto->categoria_id }}</td>
                <td>{{ $producto->proveedor->nombre ?? $producto->proveedor_id }}</td>
                <td>{{ $producto->unidad_medida }}</td>
                <td class="text-center">
                    <span class="badge {{ $producto->activo ? 'active' : 'inactive' }}">
                        {{ $producto->activo ? 'Activo' : 'Inactivo' }}
                    </span>
                </td>
                <td class="text-center">{{ $producto->imagen ? '✔' : '✖' }}</td>
                <td class="nowrap">{{ $producto->fecha_ultima_venta ? date('d/m/y', strtotime($producto->fecha_ultima_venta)) : '-' }}</td>
                <td class="nowrap">{{ $producto->fecha_caducidad ? date('d/m/y', strtotime($producto->fecha_caducidad)) : '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>