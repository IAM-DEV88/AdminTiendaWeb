<?php
include('conn.php');
$cliente = json_decode($_POST['elimina'], true);

try {
	$sql = "DELETE FROM cliente WHERE id = :id";
	$query = $pdo->prepare($sql);
	$query->bindParam(':id', $cliente['id'], PDO::PARAM_INT);
	$query->execute();
} catch (PDOException $e) {
	echo 'PDOException : '.  $e->getMessage();
}
?>