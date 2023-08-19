<?php
include('conn.php');

$correo = "OR correo LIKE '%".json_decode($_POST['buscar'])."%') ";
$telefono = "OR telefono LIKE '%".json_decode($_POST['buscar'])."%' ".$correo;
$direccion = "OR direccion LIKE '%".json_decode($_POST['buscar'])."%' ".$telefono;
$nombre = "AND (nombre LIKE '%".json_decode($_POST['buscar'])."%' ".$direccion;
$vinculo = "WHERE (vinculo='Proveedor') ".$nombre;
$buscar = "SELECT id, vinculo, nombre, direccion, telefono, correo FROM cliente ".$vinculo;
$query = $pdo->prepare($buscar);
$query->execute();
$resultado = $query->fetchAll();
echo json_encode($resultado);
?>