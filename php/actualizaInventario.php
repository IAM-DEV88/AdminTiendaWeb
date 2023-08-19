<?php
include('conn.php');

$inventario = json_decode($_POST['inventario'], true);
$actualiza = "`id_cliente`='".$inventario['proveedorid']."',`articulo`='".$inventario['articulo']."',`barcode`='".$inventario['barcode']."',`disponible`='".$inventario['disponible']."',`valor`='".$inventario['valor']."'";
$guarda = "UPDATE inventario SET ".$actualiza." WHERE id='".$inventario['id']."'";
$query = $pdo->prepare($guarda);
$query->execute();
?>