<?php
include('conn.php');

$correo = "OR telefono LIKE '%".json_decode($_POST['buscar'])."%' ";
$telefono = "OR telefono LIKE '%".json_decode($_POST['buscar'])."%' ".$correo;
$buscar = "SELECT id, nombre, direccion, telefono, correo, nit FROM cliente WHERE nombre LIKE '%".json_decode($_POST['buscar'])."%' ".$telefono;
$query = $pdo->prepare($buscar);
$query->execute();
$resultado = $query->fetchAll();
echo json_encode($resultado, true);
?>