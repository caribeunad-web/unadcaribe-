<?php
/*
 * conexion.php
 * Conecta el formulario del index.html con los archivos de diplomas.
 *
 * Estructura esperada:
 *
 * /sistema/
 *   index.html
 *   conexion.php
 *   /diplomas/
 *       46183.html
 *       46184.html
 *       ...
 */

header('Content-Type: text/html; charset=UTF-8');

// Recibir datos del formulario
$acta = isset($_POST['usuario']) ? trim($_POST['usuario']) : '';
$documento = isset($_POST['contrasena']) ? trim($_POST['contrasena']) : '';

// Validar que se haya enviado el acta
if ($acta === '') {
    mostrarError('Debe ingresar el número de Acta o Registro.');
}

// Solo permitimos números para evitar rutas no deseadas
if (!preg_match('/^[0-9]+$/', $acta)) {
    mostrarError('El código del Acta o Registro no es válido.');
}

// Si quieres que también se valide el documento, descomenta:
// if ($documento === '') {
//     mostrarError('Debe ingresar el número de Documento.');
// }

// El archivo HTML se identifica por el código del acta.
// Ejemplo: Acta 46183 -> diplomas/46183.html
$archivo = __DIR__ . '/diplomas/' . $acta . '.html';

// Verificar que exista el diploma
if (!file_exists($archivo)) {
    mostrarError('No se encontró un diploma asociado al Acta o Registro: ' . htmlspecialchars($acta, ENT_QUOTES, 'UTF-8'));
}

// Mostrar el diploma
readfile($archivo);
exit;


/**
 * Mostrar mensaje de error.
 */
function mostrarError($mensaje)
{
    $mensaje = htmlspecialchars($mensaje, ENT_QUOTES, 'UTF-8');

    echo '<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de Diploma</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f2f2f2;
            text-align: center;
            padding: 60px 20px;
        }

        .mensaje {
            max-width: 600px;
            margin: auto;
            background: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 3px 12px rgba(0,0,0,.15);
        }

        .error {
            color: #b00020;
            font-size: 20px;
            margin-bottom: 25px;
        }

        a {
            display: inline-block;
            padding: 10px 20px;
            background: #1B4F87;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        a:hover {
            background: #163e69;
        }
    </style>
</head>
<body>
    <div class="mensaje">
        <div class="error">' . $mensaje . '</div>
        <a href="index.html">Volver a consultar</a>
    </div>
</body>
</html>';

    exit;
}
