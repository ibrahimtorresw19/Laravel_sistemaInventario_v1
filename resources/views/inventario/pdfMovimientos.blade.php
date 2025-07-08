<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Listado de Movimientos</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .header { text-align: center; margin-bottom: 20px; }
        .badge {
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 12px;
            color: white;
        }
        .active { background-color: #28a745; }
        .inactive { background-color: #dc3545; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Listado de Movimientos</h1>
        <p>Generado el: {{ now()->format('d/m/Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                    <th>Tipo</th>
                        <th>Cantidad</th>
                        <th>Producto</th>
                        <th>Almacén</th>
                        <th>Registrado por</th>
                        <th>Responsable</th>
                        <th>Fecha Movimiento</th>
                        <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($movimientos as $movimiento)
            <tr>
                 <td>
                            @if($movimiento->tipo == 'entrada')
                                <span class="badge badge-success">Entrada</span>
                            @elseif($movimiento->tipo == 'salida')
                                <span class="badge badge-danger">Salida</span>
                            @else
                                <span class="badge badge-info">Ajuste</span>
                            @endif
                        </td>
                        <td>{{ number_format($movimiento->cantidad) }}</td>
                        <td>{{ $movimiento->producto->nombre }}</td>
                        <td>{{ $movimiento->almacen->nombre ?? 'N/A' }}</td>
                        <td>{{ $movimiento->usuario->name }}</td>
                        <td>{{ $movimiento->responsable ?? 'N/A' }}</td>
                        <td>{{ $movimiento->fecha_movimiento->format('d/m/Y H:i') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
