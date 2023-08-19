<?php
include('conn.php');

$cliente = json_decode($_POST['guarda'], true);

$nuevo = "INSERT INTO cliente (id, vinculo, ingreso, nombre, direccion, telefono, correo, nit, nacimiento) VALUES ('', :vinculo, :ingreso, :nombre, :direccion, :telefono, :correo, :nit, :nacimiento)";
$query = $pdo->prepare($nuevo);
var_dump($query);
$query->bindParam(':vinculo', $cliente['vinculo'], PDO::PARAM_STR);
$query->bindParam(':ingreso', $cliente['ingreso'], PDO::PARAM_STR);
$query->bindParam(':nombre', $cliente['nombre'], PDO::PARAM_STR);
$query->bindParam(':direccion', $cliente['direccion'], PDO::PARAM_STR);
$query->bindParam(':telefono', $cliente['telefono'], PDO::PARAM_STR);
$query->bindParam(':correo', $cliente['correo'], PDO::PARAM_STR);
$query->bindParam(':nit', $cliente['nit'], PDO::PARAM_STR);
$query->bindParam(':nacimiento', $cliente['nacimiento'], PDO::PARAM_STR);
$query->execute();


?>