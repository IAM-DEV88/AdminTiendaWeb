<?php
include('conn.php');

$factura = json_decode($_POST['actualiza'], true);
for ($i=0; $i<count($factura['venta']); $i++) { 
	$actualiza = "`anulado`='".$factura['venta'][$i]['anulado']."'";
	$guarda = "UPDATE venta SET ".$actualiza." WHERE id='".$factura['venta'][$i]['id']."'";
	$query = $pdo->prepare($guarda);
	$query->execute();
	# code...
}
for ($i=0; $i<count($factura['garantia']); $i++) { 
	$actualiza = "`detalle`='".$factura['garantia'][$i]['detalle']."'";
	$guarda = "UPDATE garantia SET ".$actualiza." WHERE id='".$factura['garantia'][$i]['id']."'";
	$query = $pdo->prepare($guarda);
	$query->execute();
	# code...
}
?>