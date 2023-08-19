<?php
session_start();
include('conn.php');

if ($_POST['nick']=="") {
	header("Location: ../index.php?error=Usuario requerido");
		exit();
	}elseif ($_POST['pass']=="") {
		header("Location: ../index.php?error=Contraseña requerida");
			exit();
		}else{
			$sqlSesion = "SELECT * FROM sesion WHERE usuario='".$_POST['nick']."' AND contrasena='".md5($_POST['pass'])."'";
			$query = $pdo->prepare($sqlSesion);
			$query->execute();
			$sesion = $query->fetchAll();
			if (count($sesion)==1) {
				$_SESSION['usuario']=$sesion[0]['usuario'];
				$sqlUsuario = "SELECT * FROM cliente WHERE usuario='".$sesion[0]['id']."'";
				$query = $pdo->prepare($sqlUsuario);
				$query->execute();
				$usuario = $query->fetch();
				$_SESSION['cajero']=$usuario['id'];
				$_SESSION['vinculo']=$usuario['vinculo'];
				$_SESSION['nombre']=$usuario['nombre'];
				header("Location: ../venta.php");
				exit();
			}else{
				header("Location: ../index.php?error=Usuario o contraseña incorrectos");
				exit();
			}
		}
		?>