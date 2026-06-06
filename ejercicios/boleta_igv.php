<?php
$subtotal   = "120.50";
$igv     = $subtotal * 0.18;
$total  = $subtotal + $igv;

echo "Total: " . $total;

?>