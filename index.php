<?php
// Carga de librerías de Composer (Dompdf y PhpSpreadsheet)
if (file_exists("vendor/autoload.php")) {
    require_once "vendor/autoload.php";
}

require_once "controller/estacioncontrollers.php";

$controller = new estacioncontrollers();
$action = isset($_GET['action']) ? $_GET['action'] : 'inicio';

// EVALUACIÓN DE ACCIONES
if ($action == 'registrar') {
    $controller->registrar();
    exit();
} elseif ($action == 'ver') {
    $controller->ver();
    exit();
} 
// === ACCIONES DE EXPORTACIÓN AGREGADAS ===
elseif ($action == 'exportarPdf') {
    $controller->exportarPdf();
    exit();
} elseif ($action == 'exportarExcel') {
    $controller->exportarExcel();
    exit();
} elseif ($action == 'exportarFilaPdf') {
    $controller->exportarFilaPdf();
    exit();
} elseif ($action == 'exportarFilaExcel') {
    $controller->exportarFilaExcel();
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Turismo Vivencial</title>
    <style>
        body {
            font-family: Arial;
            background-image: url(images.jpg);
            background-size: cover;
            background-position: center;
            text-align: center;
        }
        .contenedor {
            width: 500px;
            margin: 80px auto;
            background-color: #8bdba0;
            padding: 30px;
            border-radius: 10px;
        }
        h1 { color: #2e6b3e; }
        a {
            display: block;
            background-color: #2e6b3e;
            color: white;
            text-decoration: none;
            padding: 12px;
            margin: 10px;
            border-radius: 5px;
        }
        a:hover { background-color: #24552f; }
    </style>
</head>
<body>

    <div class="contenedor">
       <h1>Turismo Vivencial</h1>
        <h2>Sistema de Control de Actividades</h2> 
        <a href="index.php?action=registrar">Registrar experiencia</a>
        <a href="index.php?action=ver">Ver experiencias</a>
    </div>

</body>
</html>