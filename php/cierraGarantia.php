<?php
include('conn.php');

$garantia = json_decode($_POST['garantia'], true);
$detalle = json_decode($_POST['detalle'], true);
$actualiza = "`estado`='Cerrada',`detalle`='".$detalle."'";
$guarda = "UPDATE garantia SET ".$actualiza." WHERE id='".$garantia."'";
$query = $pdo->prepare($guarda);
$query->execute();
?>