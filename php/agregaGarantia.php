<?php
include('conn.php');

$garantia = json_decode($_POST['garantia'], true);

$sqlGarantia = "INSERT INTO `garantia`(`id`, `id_factura`, `fecha_inicio`, `estado`, `detalle`) VALUES ('', ".$_POST['garantia'].", '".date('Y-m-d')."', 'Pendiente', '')";
var_dump($sqlGarantia);
$query = $pdo->prepare($sqlGarantia);
$query->execute();


?>