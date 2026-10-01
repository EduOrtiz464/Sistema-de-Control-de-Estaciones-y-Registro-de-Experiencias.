<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar experiencia</title>
    <style>
        body { font-family: Arial; background-color: #f2f2f2; }
        .contenedor { width: 450px; margin: 50px auto; background: white; padding: 30px; border-radius: 10px; }
        input, select { width: 100%; padding: 10px; margin: 8px 0 15px; box-sizing: border-box; }
        button { width: 100%; padding: 12px; background-color: #2e6b3e; color: white; border: none; cursor: pointer; }
        a { display: block; margin-top: 15px; text-align: center; }
    </style>
</head>
<body>

<div class="contenedor">
    <h2>Registrar Experiencia</h2>
    <form method="POST">
        <label>Visitante:</label>
        <select name="visitante" required>
            <option value="">Seleccione un visitante</option>
            <?php while ($fila = $visitantes->fetch_assoc()) { ?>
                <option value="<?php echo $fila["id"]; ?>">
                    <?php echo $fila["nombre"]; ?>
                </option>
            <?php } ?>
        </select>

        <label>Actividad:</label>
        <select name="estacion" required>
            <option value="">Seleccione La Actividad</option>
            <option value="Danza Yanesha">Danza Yanesha</option>
            <option value="Cuentos e historias">Cuentos e historias</option>
            <option value="Orquidiario">Recorrido por el orquidiario</option>
            <option value="Juegos ancestrales">Juegos ancestrales</option>
            <option value="Vestimenta tradicional">Vestimenta tradicional</option>
            <option value="Pintura facial">Pintura facial</option>
        </select>

        <label>Fecha:</label>
        <input type="date" name="fecha" required>

        <button type="submit" name="registrar">Registrar experiencia</button>
    </form>

    <a href="index.php">Volver al inicio</a>
</div>

</body>
</html>