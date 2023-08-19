<?php
include('conn.php');
$inventario = json_decode($_POST['inventario'], true);

try {
	$sql = "DELETE FROM inventario WHERE id = :id";
	$query = $pdo->prepare($sql);
	$query->bindParam(':id', $inventario['id'], PDO::PARAM_INT);
	$query->execute();
} catch (PDOException $e) {
	echo 'PDOException : '.  $e->getMessage();
}
?>