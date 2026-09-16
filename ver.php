<?php

require_once "conexion.php";

$sql = "SELECT 
            experiencias.id,
            visitantes.nombre,
            visitantes.documento,
            experiencias.estacion,
            experiencias.fecha
        FROM experiencias
        INNER JOIN visitantes
        ON experiencias.visitante_id = visitantes.id";

$resultado = $conexion->query($sql);

?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <title>Experiencias</title>

    <style>

        body {
            font-family: Arial;
            background-color: #f2f2f2;
        }

        .contenedor {
            width: 800px;
            margin: 50px auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #2e6b3e;
            color: white;
        }

        a {
            display: block;
            margin-top: 20px;
            text-align: center;
        }

    </style>

</head>

<body>

<div class="contenedor">

    <h2>Experiencias Registradas</h2>

    <table>

        <tr>

            <th>Visitante</th>
            <th>Documento</th>
            <th>Estación</th>
            <th>Fecha</th>

        </tr>

        <?php while ($fila = $resultado->fetch_assoc()) { ?>

        <tr>

            <td>
                <?php echo $fila["nombre"]; ?>
            </td>

            <td>
                <?php echo $fila["documento"]; ?>
            </td>

            <td>
                <?php echo $fila["estacion"]; ?>
            </td>

            <td>
                <?php echo $fila["fecha"]; ?>
            </td>

        </tr>

        <?php } ?>

    </table>

    <a href="index.php">Volver al inicio</a>

</div>

</body>

</html>