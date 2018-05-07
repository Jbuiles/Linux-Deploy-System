<?php
//Get Linux Current User
#$md= get_current_user ();
$processUser = posix_getpwuid(posix_geteuid());//gets process owner
$User= $processUser['name'];
include "/home/$User/git/it490/config.php";

//Connect To Database
$servername = "192.168.2.2";//Set to ip of Orchestration Server
$username = "dev";
$password = "12345";
$dbname="packages";

try {
	$con = new PDO ("mysql:host=$servername;dbname=$dbname", $username, $password);
	$sql = "INSERT INTO packages (version,server,path) VALUES (:Version, :Server, :Path)";
	$result = $con->prepare($sql);
	$result->bindParam(':Version', $Version);
	$result->bindParam(':Server', $Server);
	$result->bindParam(':Path', $Path);
	$result->execute();#Write Version/Server/Path to sql table

	$filename ="$Server$Version.tar.gz";#Setup format for File name
	shell_exec("cd /home/$User/git && tar -cvzf $filename it490");#Zip Folder
	shell_exec("cd /home/$User/git && scp $filename orchestration@$servername:Orchestration/$Server"); #Copy Zip to Orchestration
	shell_exec("php /home/$User/Documents/pass.php"); #Sends Update notice to Orchestration
}

catch(PDOException $e) {
	die('Failed to connect to db: ' . $e->getMessage());
}

$con = null;

?>
