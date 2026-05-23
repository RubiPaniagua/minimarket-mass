<?php
// ============================================
// BOLETA DE PAGO - MINIMARKET MASS
// Trabajador: Carlos Eduardo Mamani Quispe
// Periodo: Mayo 2026
// Autor: [Tu nombre completo]
// ============================================

// ============================================
// 1. DATOS DEL TRABAJADOR
// ============================================

$nombre      = "Carlos Eduardo Mamani Quispe";
$dni         = "74521893";
$cargo       = "Jefe de almacén";
$tienda      = "Mass Cayma";
$periodo     = "Mayo 2026";
$dias_trab   = 30;

// ============================================
// 2. INGRESOS
// ============================================

$sueldo_base       = 2850.00;
$asig_familiar     = 102.50;
$horas_extras      = 12;
$valor_hora_extra  = 18.50;

// ============================================
// 3. TASAS DE DESCUENTO
// ============================================

$tasa_afp      = 0.13;
$tasa_renta    = 0.08;
$tasa_essalud  = 0.09;

// ============================================
// 4. CÁLCULOS
// ============================================

// Pago total por horas extras
$pago_horas_extras = $horas_extras * $valor_hora_extra;

// Total de ingresos
$total_ingresos = $sueldo_base + $asig_familiar + $pago_horas_extras;

// Descuento AFP
$descuento_afp = $total_ingresos * $tasa_afp;

// Descuento de renta
$descuento_renta = $total_ingresos * $tasa_renta;

// Total descuentos
$total_descuentos = $descuento_afp + $descuento_renta;

// Sueldo neto
$sueldo_neto = $total_ingresos - $total_descuentos;

// EsSalud pagado por la empresa
$essalud = $total_ingresos * $tasa_essalud;

// Costo total para la empresa
$costo_empresa = $total_ingresos + $essalud;

// Fecha actual
$fecha_actual = date("d/m/Y");

// Sueldo proporcional por 22 días
$sueldo_proporcional = ($sueldo_base / 30) * 22;

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Boleta de pago</title>

    <style>

        body{
            font-family: Arial, Helvetica, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        .boleta{
            width: 800px;
            margin: auto;
            background-color: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0,0,0,0.2);
        }

        h1{
            text-align: center;
            color: #1b4332;
        }

        h3{
            padding: 10px;
            border-radius: 5px;
            color: white;
        }

        .ingresos{
            background-color: #2d6a4f;
        }

        .descuentos{
            background-color: #d00000;
        }

        .extras{
            background-color: #003566;
        }

        table{
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table td{
            border: 1px solid #ccc;
            padding: 10px;
        }

        .titulo{
            font-weight: bold;
            background-color: #eeeeee;
        }

        .neto{
            background-color: #ffd60a;
            font-size: 20px;
            font-weight: bold;
        }

    </style>

</head>
<body>

<div class="boleta">

    <h1>BOLETA DE PAGO — MINIMARKET MASS</h1>

    <p>
        <strong>Tienda:</strong> <?= $tienda; ?> |
        <strong>Periodo:</strong> <?= $periodo; ?> |
        <strong>Fecha:</strong> <?= $fecha_actual; ?>
    </p>

    <table>

        <tr>
            <td class="titulo">Trabajador</td>
            <td><?= $nombre; ?></td>
        </tr>

        <tr>
            <td class="titulo">DNI</td>
            <td><?= $dni; ?></td>
        </tr>

        <tr>
            <td class="titulo">Cargo</td>
            <td><?= $cargo; ?></td>
        </tr>

        <tr>
            <td class="titulo">Días trabajados</td>
            <td><?= $dias_trab; ?></td>
        </tr>

    </table>

    <!-- INGRESOS -->

    <h3 class="ingresos">INGRESOS</h3>

    <table>

        <tr>
            <td>Sueldo base</td>
            <td>S/ <?= number_format($sueldo_base, 2); ?></td>
        </tr>

        <tr>
            <td>Asignación familiar</td>
            <td>S/ <?= number_format($asig_familiar, 2); ?></td>
        </tr>

        <tr>
            <td>
                Horas extras
                (<?= $horas_extras; ?> × S/ <?= number_format($valor_hora_extra, 2); ?>)
            </td>

            <td>S/ <?= number_format($pago_horas_extras, 2); ?></td>
        </tr>

        <tr>
            <td><strong>Total ingresos</strong></td>
            <td>
                <strong>
                    S/ <?= number_format($total_ingresos, 2); ?>
                </strong>
            </td>
        </tr>

    </table>

    <!-- DESCUENTOS -->

    <h3 class="descuentos">DESCUENTOS</h3>

    <table>

        <tr>
            <td>AFP (13%)</td>
            <td>S/ <?= number_format($descuento_afp, 2); ?></td>
        </tr>

        <tr>
            <td>Impuesto a la Renta (8%)</td>
            <td>S/ <?= number_format($descuento_renta, 2); ?></td>
        </tr>

        <tr>
            <td><strong>Total descuentos</strong></td>
            <td>
                <strong>
                    S/ <?= number_format($total_descuentos, 2); ?>
                </strong>
            </td>
        </tr>

    </table>

    <!-- SUELDO NETO -->

    <table>

        <tr class="neto">
            <td>SUELDO NETO A PAGAR</td>
            <td>S/ <?= number_format($sueldo_neto, 2); ?></td>
        </tr>

    </table>

    <!-- DATOS EXTRA -->

    <h3 class="extras">INFORMACIÓN ADICIONAL</h3>

    <table>

        <tr>
            <td>EsSalud pagado por la empresa (9%)</td>
            <td>S/ <?= number_format($essalud, 2); ?></td>
        </tr>

        <tr>
            <td>Costo total para la empresa</td>
            <td>S/ <?= number_format($costo_empresa, 2); ?></td>
        </tr>

        <tr>
            <td>Sueldo proporcional por 22 días</td>
            <td>S/ <?= number_format($sueldo_proporcional, 2); ?></td>
        </tr>

    </table>

</div>

</body>
</html>