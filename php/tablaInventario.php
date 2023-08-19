<?php
include('conn.php');
$buscar = "SELECT * FROM inventario";
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