<?php
require "lib/Database.php";
$Database = new Database(); // create an instance of database

$patientCHI = $_POST["patientCHI"];
echo $patientCHI;

$Database->insert("DELETE FROM dosagesdue WHERE patientID = ?",
    array("i", $patientCHI));

header('Location: ' . $_SERVER['HTTP_REFERER']);