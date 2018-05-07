<?php
//Get Linux Current User
#$md= get_current_user ();
$processUser = posix_getpwuid(posix_geteuid());//gets process owner
$User= $processUser['name'];
include "/home/$User/git/it490/config.php";

//Connect To Database
$servername = "192.168.2.2";//Set to IP of Orchestration Server
$username = "qa";
$password = "12345";
$dbname="packages";

try {
	$con = new PDO ("mysql:host=$servername;dbname=$dbname", $username, $password);

	//connect to DB and pull latest package path
	$sql = "SELECT path FROM packages order by id DESC limit 1";
	$result = $con->prepare($sql);
	$result->execute();
	$row = $result->fetch(PDO::FETCH_BOTH);
	$return ='0';
	$NewPath= $row[$return];
	$filename="$Server$Version.tar.gz";#Set filename format

	//Connect to DB and pull latest version number
	$sql = "SELECT version FROM packages order by id DESC limit 1";
	$result = $con->prepare($sql);
	$result->execute();
	$row = $result->fetch(PDO::FETCH_BOTH);
	$return ='0';
	$NewVersion= $row[$return];
	$Updatedname="$Server$NewVersion.tar.gz";#Get latest Filename

	//Run shell commands to fetch & install newest version
	shell_exec ("cd /home/$User/git/ && rm -rf it490");
	shell_exec("scp orchestration@$servername:$NewPath /home/$User/git");
	shell_exec("cd /home/$User/git && tar -xvzf $Updatedname");
}

catch(PDOException $e) {
	die('Failed to connect to db: ' . $e->getMessage());
}
$con = null;
?>
