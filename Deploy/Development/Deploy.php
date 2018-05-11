<?php
$processUser = posix_getpwuid(posix_geteuid());//gets process owner
$User= $processUser['name'];
$Folder="";#Set this to where your application is installed
include ""; //Link the path to where your config.php file is located

$servername = "";//Set to ip of Orchestration Server
$username = ""; //Set the username of your database
$password = ""; //Set the password for your username
$dbname=""; //Set the database name


//Connect To Database
//This code gets the Version,Server and path values from the database and appends them as a file name for the packages you want sent
try {
	$con = new PDO ("mysql:host=$servername;dbname=$dbname", $username, $password);
	$sql = "INSERT INTO packages (version,server,path) VALUES (:Version, :Server, :Path)";
	$result = $con->prepare($sql);
	$result->bindParam(':Version', $Version);
	$result->bindParam(':Server', $Server);
	$result->bindParam(':Path', $Path);
	$result->execute();#Write Version/Server/Path to sql table

	$filename ="$Server$Version.tar.gz";#Setup format for File name
	shell_exec("cd /home/$User/git && tar -cvzf $filename $Folder);#Zips up Folder
	shell_exec("cd /home/$User/git && scp $filename orchestration@$servername:Orchestration/$Server"); #Copy Zip to Orchestration
	shell_exec("php /home/$User/Documents/pass.php"); #Sends Update notice to Orchestration
}

catch(PDOException $e) {
	die('Failed to connect to db: ' . $e->getMessage());
}

$con = null;

?>
