<?php
include('conn.php');
$termino = "LIKE '%".json_decode($_POST['buscar'])."%' OR barcode LIKE '%".json_decode($_POST['buscar'])."%'";
$buscar = "SELECT * FROM inventario WHERE articulo ".$termino;
$query = $pdo->prepare($buscar);
$query->execute();
$resultado = $query->fetchAll();
for ($i=0; $i < count($resultado); $i++) { 
	if ($resultado[$i]['id_cliente']!=0) {
		$buscar = "SELECT * FROM cliente WHERE id=".$resultado[$i]['id_cliente'];
		$query = $pdo->prepare($buscar);
		$query->execute();
		$resultado2[$i] = $query->fetchAll();
		$resultado[$i]["proveedor"] = $resultado2[$i];
	}
}
echo json_encode($resultado);
?>