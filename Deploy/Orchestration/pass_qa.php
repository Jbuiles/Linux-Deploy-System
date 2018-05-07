<?php
session_start();
$reg = (object) [
    'boolean' => True
];
$SESSION['json'] = json_encode($reg);
include("send_qa.php");
?>
