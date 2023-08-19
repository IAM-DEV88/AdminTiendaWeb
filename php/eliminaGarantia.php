<?php
include('conn.php');
$garantia = json_decode($_POST['garantia'], true);

try {
	$sql = "DELETE FROM garantia WHERE id = :id";
	$query = $pdo->prepare($sql);
	$query->bindParam(':id', $garantia, PDO::PARAM_INT);
	$query->execute();
} catch (PDOException $e) {
	echo 'PDOException : '.  $e->getMessage();
}
?>