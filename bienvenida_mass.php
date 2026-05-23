<?php
// 1. Datos en variables PHP
$nombreTienda = "Paniagua";

date_default_timezone_set('America/Lima');
$fechaHoy = date('d/m/Y'); 

$categorias = ["Abarrotes", "Lácteos y Embutidos", "Bebidas y Licores"];

$promocionDia = "¡Lleva tu Six-Pack de Pilsen + papitas Lay's con 20% de descuento!";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Bienvenida Mass</title>
</head>
<body>

    <h1>Bienvenido a Mass — <?php echo $nombreTienda; ?></h1>

    <p>Fecha de hoy: <?php echo $fechaHoy; ?></p>

    <ul>
        <?php foreach ($categorias as $categoria): ?>
            <li><?php echo $categoria; ?></li>
        <?php endforeach; ?>
    </ul>

    <p><strong>Promoción del día: <?php echo $promocionDia; ?></strong></p>

</body>
</html>