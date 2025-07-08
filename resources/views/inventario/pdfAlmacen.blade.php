<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Listado de Almacen</title>
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
        <h1>Listado de Almacen</h1>
        <p>Generado el: {{ now()->format('d/m/Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Capacidad</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach($almacenes as $almacen)
            <tr>
                <td>{{ $almacen->nombre }}</td>
                <td>{{ $almacen->ubicacion }}</td>
                 <td>{{ $almacen->capacidad }}</td>
                <td>
                    <span class="badge {{ $almacen->activo ? 'active' : 'inactive' }}">
                        {{ $almacen->activo ? 'Activo' : 'Inactivo' }}
                    </span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
