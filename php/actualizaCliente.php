<?php
include('conn.php');

$cliente = json_decode($_POST['actualiza'], true);
$actualiza = "`vinculo`='".$cliente['vinculo']."',`ingreso`='".$cliente['ingreso']."',`nombre`='".$cliente['nombre']."',`direccion`='".$cliente['direccion']."',`telefono`='".$cliente['telefono']."',`correo`='".$cliente['correo']."',`nit`='".$cliente['nit']."',`nacimiento`='".$cliente['nacimiento']."'";
$guarda = "UPDATE cliente SET ".$actualiza." WHERE id='".$cliente['id']."'";
$query = $pdo->prepare($guarda);
$query->execute();

$msgSalida = "La informacion ha sido actualizada.";

if ($_POST['habilita']===true) {
	if ($cliente['nickname']!="" & $cliente['contrasena']!="") {
		$buscaUsuario = "SELECT usuario FROM sesion WHERE id='".$_POST['usuario']."'";
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
			$msgSalida = "Usuario habilitado correctamente.";
		}elseif($usuario==true & $_POST['usuario']!=""){
			$comparaClave = "SELECT contrasena FROM sesion WHERE id='".$_POST['usuario']."'";
			$query = $pdo->prepare($comparaClave);
			$query->execute();
			$actual = $query->fetch();
			$nuevaContrasena = "";
			if ($cliente['contrasena']!=$actual['contrasena']) {
				$nuevaContrasena = ",`contrasena`='".md5($cliente['contrasena'])."'";
			}
			$actualiza = "`usuario`='".$cliente['nickname']."'".$nuevaContrasena;
			$guarda = "UPDATE sesion SET ".$actualiza." WHERE id='".$_POST['usuario']."'";
			$query = $pdo->prepare($guarda);
			$query->execute();
			$msgSalida = "La informacion ha sido actualizada.";
		}else{
			$msgSalida = $usuario."Para continuar utilice un nombre de usuario diferente.";
			exit();
		}
	}
}

echo $msgSalida;
?>