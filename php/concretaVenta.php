<?php
include('conn.php');

$factura = "INSERT INTO factura (id, fecha, id_cajero, id_cliente) VALUES ('', '".date('Y-m-d H:i:s')."', :id_cajero, :id_cliente)";
$query = $pdo->prepare($factura);
$query->bindParam(':id_cajero', $_POST['cajero'], PDO::PARAM_INT);
$query->bindParam(':id_cliente', $_POST['cliente'], PDO::PARAM_STR);
$query->execute();

$reciente = "SELECT MAX(id) FROM factura";
$query = $pdo->prepare($reciente);
$query->execute();
$reciente = $query->fetch();

$articulo = json_decode($_POST['venta'], true);
$i=0;
foreach ($articulo as $key => $value) {
	$venta = "INSERT INTO venta (id, id_factura, id_inventario, cantidad, valor, anulado) VALUES ('', :id_factura,  :id_inventario, :cantidad, :valor, '')";
	$query = $pdo->prepare($venta);
	$query->bindParam(':id_factura', $reciente[0], PDO::PARAM_INT);
	$query->bindParam(':id_inventario', $articulo[$i]['id'], PDO::PARAM_INT);
	$query->bindParam(':cantidad', $articulo[$i]['cantidad'], PDO::PARAM_STR);
	$query->bindParam(':valor', $articulo[$i]['valor'], PDO::PARAM_STR);
	$query->execute();

	$nuevoDisp = intval($articulo[$i]['disponible'])-intval($articulo[$i]['cantidad']);
	
	$actualiza = "disponible='".$nuevoDisp."'";
	$guarda = "UPDATE inventario SET ".$actualiza." WHERE id='".intval($articulo[$i]['id'])."'";
	$query = $pdo->prepare($guarda);
	$query->execute();
	$i++;
}
?>