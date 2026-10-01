<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Experiencias</title>
    <style>
        body { font-family: Arial; background-color: #f2f2f2; }
        .contenedor { width: 850px; margin: 40px auto; background: white; padding: 30px; border-radius: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: center; }
        th { background-color: #2e6b3e; color: white; }
        a { text-decoration: none; }
        .volver { display: block; margin-top: 20px; text-align: center; }
        
        /* Estilos del Filtro de Fechas y Botones */
        .filtro-container {
            background-color: #e9f5ec;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            border: 1px solid #c2e0cb;
        }
        .form-filtro {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }
        .form-filtro label { font-weight: bold; font-size: 14px; }
        .form-filtro input[type="date"] { padding: 6px; border: 1px solid #ccc; border-radius: 4px; }
        
        .btn-filtrar {
            background-color: #2e6b3e;
            color: white;
            border: none;
            padding: 7px 15px;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
        }
        .btn-filtrar:hover { background-color: #24552f; }
        
        .acciones-exportar {
            margin-top: 15px;
            display: flex;
            gap: 10px;
        }
        .btn-export {
            padding: 8px 15px;
            color: white;
            border-radius: 5px;
            font-size: 14px;
            font-weight: bold;
        }
        .btn-pdf { background-color: #d9534f; }
        .btn-excel { background-color: #2e6b3e; }
        .btn-limpiar { background-color: #6c757d; }
        .btn-sm { padding: 4px 8px; font-size: 12px; margin: 2px; display: inline-block; }
        h2{font-family: Arial, "Helvetica Neue", Helvetica, sans-serif;
            background-color: green;
            color:white;
            font-size: 50px; margin: 10px; display: inline-block; }
    </style>    
</head>
<body>

<div class="contenedor">
    <h2>Experiencias Registradas</h2>

    <!-- FORMULARIO DE FILTRO POR FECHA -->
    <div class="filtro-container">
        <form method="GET" action="index.php" class="form-filtro">
            <input type="hidden" name="action" value="ver">

            <label for="fecha_inicio">Desde:</label>
            <input type="date" id="fecha_inicio" name="fecha_inicio" value="<?php echo $_GET['fecha_inicio'] ?? ''; ?>">

            <label for="fecha_fin">Hasta:</label>
            <input type="date" id="fecha_fin" name="fecha_fin" value="<?php echo $_GET['fecha_fin'] ?? ''; ?>">

            <button type="submit" class="btn-filtrar">Filtrar</button>
            
            <?php if (!empty($_GET['fecha_inicio']) || !empty($_GET['fecha_fin'])): ?>
                <a href="index.php?action=ver" class="btn-export btn-limpiar">Limpiar Filtro</a>
            <?php endif; ?>
        </form>

        <!-- BOTONES DE EXPORTACIÓN (Incluyen los parámetros de fecha) -->
        <?php 
            $params_fecha = "";
            if (!empty($_GET['fecha_inicio'])) $params_fecha .= "&fecha_inicio=" . $_GET['fecha_inicio'];
            if (!empty($_GET['fecha_fin'])) $params_fecha .= "&fecha_fin=" . $_GET['fecha_fin'];
        ?>
        <div class="acciones-exportar">
            <a href="index.php?action=exportarPdf<?php echo $params_fecha; ?>" class="btn-export btn-pdf" target="_blank">
                Exportar Filtrado a PDF
            </a>
            <a href="index.php?action=exportarExcel<?php echo $params_fecha; ?>" class="btn-export btn-excel">
                Exportar Filtrado a Excel
            </a>
        </div>
    </div>

    <!-- TABLA DE RESULTADOS -->
    <table>
        <tr>
            <th>Visitante</th>
            <th>Documento</th>
            <th>Estación</th>
            <th>Fecha</th>
            <th>Acciones</th>
        </tr>
        <?php if ($resultado && $resultado->num_rows > 0): ?>
            <?php while ($fila = $resultado->fetch_assoc()) { ?>
            <tr>
                <td><?php echo htmlspecialchars($fila["nombre"]); ?></td>
                <td><?php echo htmlspecialchars($fila["documento"]); ?></td>
                <td><?php echo htmlspecialchars($fila["estacion"]); ?></td>
                <td><?php echo htmlspecialchars($fila["fecha"]); ?></td>
                <td>
                    <a href="index.php?action=exportarFilaPdf&id=<?php echo $fila['id']; ?>" class="btn-export btn-pdf btn-sm" target="_blank">PDF</a>
                    <a href="index.php?action=exportarFilaExcel&id=<?php echo $fila['id']; ?>" class="btn-export btn-excel btn-sm">Excel</a>
                </td>
            </tr>
            <?php } ?>
        <?php else: ?>
            <tr>
                <td colspan="5">No se encontraron experiencias en el rango de fechas seleccionado.</td>
            </tr>
        <?php endif; ?>
    </table>

    <a href="index.php" class="volver">Volver al inicio</a>
</div>

</body>
</html>