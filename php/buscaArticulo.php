<?php
include('conn.php');
$termino = "LIKE '%".json_decode($_POST['buscar'])."%' OR barcode LIKE '%".json_decode($_POST['buscar'])."%'";
$buscar = "SELECT id, articulo, disponible, valor FROM inventario WHERE articulo ".$termino;
$query = $pdo->prepare($buscar);
$query->execute();
$resultado = $query->fetchAll();
echo json_encode($resultado, true);
?>