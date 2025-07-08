<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Listado de Proveedores<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Listado de Proveedores</title>
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
        <h1>Listado de Proveedores</h1>
        <p>Generado el: {{ now()->format('d/m/Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                    <th>Nombre</th>
                <th>Teléfono</th>
                <th>Email</th>
                <th>Dirección</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($proveedores as $proveedor)
            <tr>
                <td>{{ $proveedor->nombre }}</td>
                <td>{{ $proveedor->telefono }}</td>
                <td>{{ $proveedor->email }}</td>
                <td>{{ $proveedor->direccion }}</td>
                <td>
                    <span class="estado-badge {{ $proveedor->activo ? 'estado-activo' : 'estado-inactivo' }}">
                        {{ $proveedor->activo ? 'Activo' : 'Inactivo' }}
                    </span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
</title>
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
        <h1>Listado de Proveedores</h1>
        <p>Generado el: {{ now()->format('d/m/Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach($proveedores as $proveedor)
            <tr>
                <td>{{ $proveedor->nombre }}</td>
                <td>{{ $proveedor->descripcion }}</td>
                <td>
                    <span class="badge {{ $proveedor->activo ? 'active' : 'inactive' }}">
                        {{ $proveedor->activo ? 'Activo' : 'Inactivo' }}
                    </span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
