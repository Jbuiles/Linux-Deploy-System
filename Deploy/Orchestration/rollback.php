<?php
//Connect To Database
$servername = "localhost";
$username = "root";
$password = "12345";
$dbname="packages";

//This deletes the last row in the package table since it references a bad package version
try {
	$con = new PDO ("mysql:host=$servername;dbname=$dbname", $username, $password);
	$sql = "DELETE FROM packages ORDER BY id DESC LIMIT 1";
	$delete = $con->prepare($sql);
	$delete->execute();
}
catch(PDOException $e) {
	die('Failed to connect to db: ' . $e->getMessage());
}
$con = null;
?>
