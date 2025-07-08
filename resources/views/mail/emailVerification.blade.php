<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Código de verificación</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f7f9fc;
        }
        .container {
            background-color: #ffffff;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .header {
            color: #2c3e50;
            border-bottom: 2px solid #3498db;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .code {
            font-size: 32px;
            letter-spacing: 5px;
            color: #e74c3c;
            background-color: #f9f9f9;
            padding: 15px 20px;
            border-radius: 5px;
            margin: 25px 0;
            text-align: center;
            font-weight: bold;
            border: 1px dashed #bdc3c7;
        }
        .footer {
            margin-top: 30px;
            font-size: 12px;
            color: #7f8c8d;
            border-top: 1px solid #eee;
            padding-top: 15px;
        }
        .button {
            display: inline-block;
            background-color: #3498db;
            color: white !important;
            text-decoration: none;
            padding: 12px 25px;
            border-radius: 5px;
            margin: 15px 0;
            font-weight: bold;
        }
        .logo {
            text-align: center;
            margin-bottom: 20px;
        }
        .logo img {
            max-height: 60px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo">
            <!-- Reemplaza con tu logo o nombre de empresa -->
            <h2 style="color: #3498db; margin: 0;">MiAplicación</h2>
        </div>
        
        <div class="header">
            <h2 style="margin: 0;">Hola {{ $user->name }}!</h2>
        </div>
        
        <p>Por favor utiliza el siguiente código para verificar tu cuenta:</p>
        
        <div class="code">{{ $code }}</div>
        
        <p>Este código es válido por <strong>30 minutos</strong>. Si no lo usas en ese tiempo, deberás solicitar uno nuevo.</p>
        
        <p>Si no reconoces esta actividad, por favor ignora este mensaje o <a href="mailto:soporte@miaplicacion.com" style="color: #3498db;">contacta a nuestro equipo de soporte</a>.</p>
        
        <div class="footer">
            <p>© {{ date('Y') }} MiAplicación. Todos los derechos reservados.</p>
            <p>Este mensaje fue enviado a {{ $user->email }}. Si no solicitaste este código, te recomendamos cambiar tu contraseña.</p>
        </div>
    </div>
</body>
</html>