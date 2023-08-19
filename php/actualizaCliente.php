<?php
include('conn.php');

$cliente = json_decode($_POST['actualiza'], true);
$actualiza = "`vinculo`='".$cliente['vinculo']."',`ingreso`='".$cliente['ingreso']."',`nombre`='".$cliente['nombre']."',`direccion`='".$cliente['direccion']."',`telefono`='".$cliente['telefono']."',`correo`='".$cliente['correo']."',`nit`='".$cliente['nit']."',`nacimiento`='".$cliente['nacimiento']."'";
$guarda = "UPDATE cliente SET ".$actualiza." WHERE id='".$cliente['id']."'";
$query = $pdo->prepare($guarda);
$query->execute();

if ($_POST['habilita']) {
	if ($cliente['nickname']!="" & $cliente['contrasena']!="") {
		$buscaUsuario = "SELECT usuario FROM sesion WHERE usuario='".$cliente['nickname']."'";
		$query = $pdo->prepare($buscaUsuario);
		$query->execute();
		$usuario = $query->fetch();
		if ($usuario==false & $_POST['usuario']=="") {
			$creaUsuario = "INSERT INTO sesion (id, usuario, contrasena) VALUES ('', :usuario, :contrasena)";
			$password = md5($cliente['contrasena']);
			$query = $pdo->prepare($creaUsuario);
			$query->bindParam(':usuario', $cliente['nickname'], PDO::PARAM_STR);
			$query->bindParam(':contrasena', $password, PDO::PARAM_STR);
			$query->execute();

			$buscaID = "SELECT id FROM sesion WHERE usuario='".$cliente['nickname']."'";
			$query = $pdo->prepare($buscaID);
			$query->execute();
			$ID = $query->fetch();

			$habilitaUsuario = "UPDATE cliente SET usuario=".$ID['id']." WHERE id='".$cliente['id']."'";
			$query = $pdo->prepare($habilitaUsuario);
			$query->execute();
			echo "Usuario habilitado correctamente.";
		}else{
			echo "Para continuar utilice un nombre de usuario diferente.";
			exit();
		}if($usuario!=false & $_POST['usuario']!=""){
			$actualiza = "`usuario`='".$cliente['nickname']."',`contrasena`='".md5($cliente['contrasena'])."'";
			$guarda = "UPDATE sesion SET ".$actualiza." WHERE id='".$usuario['usuario']."'";
			$query = $pdo->prepare($guarda);
			$query->execute();
			echo "La informacion ha sido actualizada.";
		}
	}
}
?>