<?php
require "lib/Database.php";
$Database = new Database(); // create an instance of database

$patientCHI = $_POST["patientCHI"];
echo $patientCHI;

// this query stops the gentamicin treatment by deleting the dosagedue values
$Database->insert("DELETE FROM dosagesdue WHERE patientID = ?",
    array("i", $patientCHI));

// redirects user to the previous page
header('Location: ' . $_SERVER['HTTP_REFERER']);