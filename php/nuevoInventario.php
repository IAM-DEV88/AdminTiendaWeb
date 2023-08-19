<?php
include('conn.php');

$articulo = json_decode($_POST['inventario'], true);

$factura = "INSERT INTO inventario (id, id_cliente, articulo, barcode, disponible, valor) VALUES ('', :id_cliente, :articulo, :barcode, :disponible, :valor)";
$query = $pdo->prepare($factura);
$query->bindParam(':id_cliente', $articulo['proveedorid'], PDO::PARAM_INT);
$query->bindParam(':articulo', $articulo['articulo'], PDO::PARAM_STR);
$query->bindParam(':barcode', $articulo['barcode'], PDO::PARAM_INT);
$query->bindParam(':disponible', $articulo['disponible'], PDO::PARAM_INT);
$query->bindParam(':valor', $articulo['valor'], PDO::PARAM_INT);
$query->execute();


?>