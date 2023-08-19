<?php
include('conn.php');
$termino = "LIKE '%".json_decode($_POST['buscar'])."%'";
$sqlFecha = "SELECT * FROM factura WHERE fecha ".$termino;
$query = $pdo->prepare($sqlFecha);
$query->execute();
$resultado = $query->fetchAll();

for ($i=0; $i < count($resultado); $i++) { 
	$sqlCajero = "SELECT nombre FROM cliente WHERE id=".$resultado[$i]['id_cajero'];
	$query = $pdo->prepare($sqlCajero);
	$query->execute();
	$resultado[$i]['cajero'] = $query->fetch();

	$sqlCliente = "SELECT nombre, nit FROM cliente WHERE id=".$resultado[$i]['id_cliente'];
	$query = $pdo->prepare($sqlCliente);
	$query->execute();
	$resultado[$i]['cliente'] = $query->fetch();

	$sqlVenta = "SELECT * FROM venta WHERE id_factura=".$resultado[$i]['id'];
	$query = $pdo->prepare($sqlVenta);
	$query->execute();
	$resultado[$i]['venta'] = $query->fetchAll();

	for ($j=0; $j < count($resultado[$i]['venta']); $j++) { 
		$sqlArticulo = "SELECT articulo FROM inventario WHERE id='".$resultado[$i]['venta'][$j]['id_inventario']."'";
		$query = $pdo->prepare($sqlArticulo);
		$query->execute();
		$resultado[$i]['venta'][$j]['nombre'] = $query->fetch();
	}

	$sqlGarantia = "SELECT * FROM garantia WHERE id_factura=".$resultado[$i]['id'];
	$query = $pdo->prepare($sqlGarantia);
	$query->execute();
	$resultado[$i]['garantia'] = $query->fetchAll();
}

echo json_encode($resultado, true);
?>