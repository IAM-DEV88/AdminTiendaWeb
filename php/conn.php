<?php
// PDO conexion data base
date_default_timezone_set('America/Bogota');
function connect() {
	$hostname = 'localhost';
	$name = 'gestorventas';
	$user = 'root';
	$password = '';
    return new PDO('mysql:host='.$hostname.';dbname='.$name, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
}
$pdo = connect();
?>