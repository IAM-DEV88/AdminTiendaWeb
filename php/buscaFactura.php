<?php
include('conn.php');
$sqlFecha = "SELECT * FROM factura WHERE id=".json_decode($_POST['buscar']);
$query = $pdo->prepare($sqlFecha);
$query->execute();
$resultado = $query->fetch();

$sqlCajero = "SELECT nombre FROM cliente WHERE id=".$resultado['id_cajero'];
$query = $pdo->prepare($sqlCajero);
$query->execute();
$resultado['cajero'] = $query->fetch();

$sqlCliente = "SELECT nombre, nit FROM cliente WHERE id=".$resultado['id_cliente'];
$query = $pdo->prepare($sqlCliente);
$query->execute();
$resultado['cliente'] = $query->fetch();

$sqlVenta = "SELECT * FROM venta WHERE id_factura=".$resultado['id'];
$query = $pdo->prepare($sqlVenta);
$query->execute();
$resultado['venta'] = $query->fetchAll();

for ($j=0; $j < count($resultado['venta']); $j++) { 
	$sqlArticulo = "SELECT articulo FROM inventario WHERE id='".$resultado['venta'][$j]['id_inventario']."'";
	$query = $pdo->prepare($sqlArticulo);
	$query->execute();
	$resultado['venta'][$j]['nombre'] = $query->fetch();
}

$sqlGarantia = "SELECT * FROM garantia WHERE id_factura=".$resultado['id'];
$query = $pdo->prepare($sqlGarantia);
$query->execute();
$resultado['garantia'] = $query->fetchAll();

echo json_encode($resultado, true);
?>