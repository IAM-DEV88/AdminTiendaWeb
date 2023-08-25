<?php
include('conn.php');

$correo = "OR correo LIKE '%".json_decode($_POST['buscar'])."%' ";
$telefono = "OR telefono LIKE '%".json_decode($_POST['buscar'])."%' ".$correo;
$direccion = "OR direccion LIKE '%".json_decode($_POST['buscar'])."%' ".$telefono;
$nombre = "WHERE nombre LIKE '%".json_decode($_POST['buscar'])."%' ".$direccion;
$sqlCliente = "SELECT id, vinculo, ingreso, nombre, direccion, telefono, correo, nit, nacimiento, usuario FROM cliente ".$nombre;
$query = $pdo->prepare($sqlCliente);
$query->execute();
$resultado = $query->fetchAll();

for ($i=0; $i < count($resultado); $i++) { 
	if ($resultado[$i]['vinculo']==="Administrador" OR $resultado[$i]['vinculo']==="Cajero" AND $resultado[$i]['usuario']!=0) {
		$sqlAdmin = "SELECT * FROM sesion WHERE id='".$resultado[$i]['usuario']."'";
		$query = $pdo->prepare($sqlAdmin);
		$query->execute();
		$resultado2 = $query->fetch();
		
		if (is_array($resultado2)) {
			$resultado[$i]['nickname'] = isset($resultado2['usuario']) ? $resultado2['usuario'] : "";
			$resultado[$i]['contrasena'] = isset($resultado2['contrasena']) ? $resultado2['contrasena'] : "";
		} else {
			$resultado[$i]['nickname'] = "";
			$resultado[$i]['contrasena'] = "";
		}	
		
		
		
	}
}

echo json_encode($resultado);
?>