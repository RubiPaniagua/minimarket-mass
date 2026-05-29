<?php

/* =========================================================
   SISTEMA MASS - MODULO PROCESAR VENTA
   Archivo: procesar_venta.php
   ========================================================= */

/* =========================================================
   VARIABLES DE ENTRADA
   ========================================================= */

// Datos del cliente
$cliente_nombre = "Alan Garcia";
$cliente_dni = "74859621";
$cliente_tipo = "vip"; // regular | frecuente | vip

// Metodo de pago
$metodo_pago = "efectivo"; // efectivo | yape | plin | tarjeta

// Productos comprados
$productos = [

    [
        "nombre" => "Inca Kola 1.5L",
        "categoria" => "bebidas",
        "precio" => 8.50,
        "cantidad" => 3
    ],

    [
        "nombre" => "Arroz Costeño 5KG",
        "categoria" => "abarrotes",
        "precio" => 26.90,
        "cantidad" => 2
    ],

    [
        "nombre" => "Leche Gloria",
        "categoria" => "lacteos",
        "precio" => 4.80,
        "cantidad" => 6
    ],

    [
        "nombre" => "Pan Frances",
        "categoria" => "panaderia",
        "precio" => 0.50,
        "cantidad" => 10
    ]

];


/* =========================================================
   VALIDACION DE DNI
   ========================================================= */

if (
    strlen($cliente_dni) != 8 ||
    !ctype_digit($cliente_dni)
) {

    echo "
    <h2 style='color:red; text-align:center;'>
        ERROR: DNI INVALIDO
    </h2>
    ";

    exit;
}


/* =========================================================
   VARIABLES GENERALES
   ========================================================= */

$total_subtotal = 0;
$total_igv = 0;
$total_general = 0;

$detalle_productos = [];


/* =========================================================
   PROCESAMIENTO DE PRODUCTOS
   ========================================================= */

foreach ($productos as $producto) {

    $nombre = $producto["nombre"];
    $categoria = strtolower($producto["categoria"]);
    $precio = $producto["precio"];
    $cantidad = $producto["cantidad"];

    /* =====================================================
       IGV SEGUN CATEGORIA
       ===================================================== */

    switch ($categoria) {

        case "abarrotes":
        case "bebidas":
        case "lacteos":
        case "limpieza":
        case "aseo personal":

            $tasa_igv = 0.18;
            break;

        case "panaderia":
        case "frutas y verduras":

            $tasa_igv = 0;
            break;

        default:

            $tasa_igv = 0.18;
            break;
    }

    /* =====================================================
       CALCULOS POR PRODUCTO
       ===================================================== */

    $subtotal = $precio * $cantidad;
    $igv_producto = $subtotal * $tasa_igv;
    $total_producto = $subtotal + $igv_producto;

    $total_subtotal += $subtotal;
    $total_igv += $igv_producto;
    $total_general += $total_producto;

    /* =====================================================
       GUARDAR DETALLE
       ===================================================== */

    $detalle_productos[] = [

        "nombre" => $nombre,
        "categoria" => $categoria,
        "precio" => $precio,
        "cantidad" => $cantidad,
        "subtotal" => $subtotal,
        "igv" => $igv_producto,
        "total" => $total_producto

    ];
}


/* =========================================================
   DESCUENTO POR MONTO TOTAL
   ========================================================= */

$descuento_monto = 0;

if ($total_general < 30) {

    $descuento_monto = 0;

} elseif ($total_general >= 30 && $total_general <= 99.99) {

    $descuento_monto = 0.05;

} elseif ($total_general >= 100 && $total_general <= 199.99) {

    $descuento_monto = 0.10;

} else {

    $descuento_monto = 0.15;
}


/* =========================================================
   DESCUENTO POR TIPO DE CLIENTE
   ========================================================= */

$descuento_cliente = 0;

switch (strtolower($cliente_tipo)) {

    case "frecuente":
        $descuento_cliente = 0.02;
        break;

    case "vip":
        $descuento_cliente = 0.05;
        break;

    default:
        $descuento_cliente = 0;
        break;
}


/* =========================================================
   CALCULO DE DESCUENTOS
   ========================================================= */

$descuento_total_porcentaje =
    $descuento_monto + $descuento_cliente;

$monto_descuento =
    $total_general * $descuento_total_porcentaje;

$total_final =
    $total_general - $monto_descuento;


/* =========================================================
   VALIDACION METODO DE PAGO
   ========================================================= */

$mensaje_pago = "";

switch ($metodo_pago) {

    case "efectivo":

        $mensaje_pago =
            "Pago en efectivo - exacto preferido";

        break;

    case "yape":
    case "plin":

        $mensaje_pago =
            "Mostrar QR del comercio";

        break;

    case "tarjeta":

        $mensaje_pago =
            "Insertar tarjeta en POS";

        break;

    default:

        $mensaje_pago =
            "Metodo de pago no reconocido";

        break;
}


/* =========================================================
   ADVERTENCIA POR MONTO ALTO
   ========================================================= */

$advertencia_pago = "";

if (
    $total_final > 500 &&
    $metodo_pago == "efectivo"
) {

    $advertencia_pago =
        "Se sugiere otro metodo para montos altos";
}


/* =========================================================
   SALUDO SEGUN HORA ACTUAL
   ========================================================= */

$hora_actual = date("H");

if ($hora_actual >= 5 && $hora_actual <= 11) {

    $saludo = "Buenos dias";

} elseif ($hora_actual >= 12 && $hora_actual <= 18) {

    $saludo = "Buenas tardes";

} elseif ($hora_actual >= 19 && $hora_actual <= 23) {

    $saludo = "Buenas noches";

} else {

    $saludo = "Tienda cerrada";
}


/* =========================================================
   FECHA Y HORA
   ========================================================= */

date_default_timezone_set("America/Lima");

$fecha_actual = date("d/m/Y");
$hora_completa = date("h:i:s A");

?>


<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <title>Comprobante MASS</title>

    <style>

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }

        .comprobante {
            width: 850px;
            margin: auto;
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px gray;
        }

        .logo {
            text-align: center;
            color: red;
            font-size: 40px;
            font-weight: bold;
        }

        .datos-tienda {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th,
        table td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: center;
        }

        table th {
            background-color: #eaeaea;
        }

        .totales {
            margin-top: 20px;
            font-size: 18px;
        }

        .mensaje {
            margin-top: 20px;
            padding: 15px;
            background-color: #f1f1f1;
            border-radius: 5px;
        }

        .advertencia {
            color: red;
            font-weight: bold;
        }

    </style>

</head>

<body>

    <div class="comprobante">

        <!-- =================================================
             ENCABEZADO
             ================================================= -->

        <div class="logo">
            MASS
        </div>

        <div class="datos-tienda">

            <p>
                Minimarket MASS - Sistema de Ventas
            </p>

            <p>
                Av. Principal 123 - Arequipa
            </p>

            <p>
                Fecha:
                <?php echo $fecha_actual; ?>

                |

                Hora:
                <?php echo $hora_completa; ?>
            </p>

        </div>


        <!-- =================================================
             SALUDO
             ================================================= -->

        <h2>
            <?php
            echo $saludo .
            ", " .
            $cliente_nombre;
            ?>
        </h2>


        <!-- =================================================
             DATOS DEL CLIENTE
             ================================================= -->

        <h3>Datos del Cliente</h3>

        <p>
            <strong>Nombre:</strong>
            <?php echo $cliente_nombre; ?>
        </p>

        <p>
            <strong>DNI:</strong>
            <?php echo $cliente_dni; ?>
        </p>

        <p>
            <strong>Tipo de Cliente:</strong>
            <?php echo strtoupper($cliente_tipo); ?>
        </p>


        <!-- =================================================
             DETALLE DE PRODUCTOS
             ================================================= -->

        <h3>Detalle de Productos</h3>

        <table>

            <tr>
                <th>Producto</th>
                <th>Categoria</th>
                <th>Precio</th>
                <th>Cantidad</th>
                <th>Subtotal</th>
                <th>IGV</th>
                <th>Total</th>
            </tr>

            <?php

            foreach ($detalle_productos as $item) {

                echo "
                <tr>

                    <td>" . $item["nombre"] . "</td>

                    <td>" . ucfirst($item["categoria"]) . "</td>

                    <td>S/ " .
                    number_format($item["precio"], 2)
                    . "</td>

                    <td>" .
                    $item["cantidad"]
                    . "</td>

                    <td>S/ " .
                    number_format($item["subtotal"], 2)
                    . "</td>

                    <td>S/ " .
                    number_format($item["igv"], 2)
                    . "</td>

                    <td>S/ " .
                    number_format($item["total"], 2)
                    . "</td>

                </tr>
                ";
            }

            ?>

        </table>


        <!-- =================================================
             TOTALES
             ================================================= -->

        <div class="totales">

            <p>
                <strong>Total Subtotal:</strong>

                S/
                <?php
                echo number_format(
                    $total_subtotal,
                    2
                );
                ?>
            </p>

            <p>
                <strong>Total IGV:</strong>

                S/
                <?php
                echo number_format(
                    $total_igv,
                    2
                );
                ?>
            </p>

            <p>
                <strong>Total General:</strong>

                S/
                <?php
                echo number_format(
                    $total_general,
                    2
                );
                ?>
            </p>

            <p>
                <strong>
                    Descuento por monto:
                </strong>

                <?php
                echo ($descuento_monto * 100);
                ?>%
            </p>

            <p>
                <strong>
                    Descuento por cliente:
                </strong>

                <?php
                echo ($descuento_cliente * 100);
                ?>%
            </p>

            <p>
                <strong>
                    Descuento Total:
                </strong>

                S/
                <?php
                echo number_format(
                    $monto_descuento,
                    2
                );
                ?>
            </p>

            <h2>

                Total Final a Pagar:

                S/
                <?php
                echo number_format(
                    $total_final,
                    2
                );
                ?>

            </h2>

        </div>


        <!-- =================================================
             METODO DE PAGO
             ================================================= -->

        <div class="mensaje">

            <h3>Metodo de Pago</h3>

            <p>
                <?php echo ucfirst($metodo_pago); ?>
            </p>

            <p>
                <?php echo $mensaje_pago; ?>
            </p>

            <?php

            if ($advertencia_pago != "") {

                echo "
                <p class='advertencia'>
                    " . $advertencia_pago . "
                </p>
                ";
            }

            ?>

        </div>

    </div>

</body>

</html>
