<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Listado de Inventario Fisico</title>
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
        <h1>Listado de Inventario Fisico</h1>
        <p>Generado el: {{ now()->format('d/m/Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                   <th>Nombre</th>
                <th>Observaciones</th>
                <th>Fecha Inicio</th>
                <th>Fecha Fin</th>
                <th>Estado</th>
                <th>Persona Encargada</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($datas as $data)
            <tr>
                   <td>{{ $data->nombre }}</td>
                <td>{{ $data->observaciones }}</td>
                <td>{{ \Carbon\Carbon::parse($data->fecha_inicio)->format('d/m/Y') }}</td>
                <td>{{ $data->fecha_fin ? \Carbon\Carbon::parse($data->fecha_fin)->format('d/m/Y') : '' }}</td>
                <td>
                    <span class="estado-badge {{ str_replace(' ', '_', strtolower($data->estado)) }}">
                        {{ $data->estado }}
                    </span>
                </td>
                <td>{{ $data->encargado }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
