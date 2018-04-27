<?php
require "lib/Database.php";
$Database = new Database(); // create an instance of database

$date = $_POST["date"];
$resultsNumber = $_POST["resultsNumber"];
$plasmaCreatinine = $_POST["plasmaCreatinine"];
$patientCHI = $_POST["patientCHI"];

$date = DateTime::createFromFormat("d/m/Y", $date);
$date = $date->format("Y-m-d");

// Displays an error when a date from the future is inputted
if (new DateTime("today") < new DateTime($date)) {
    $message = "You cannot input a date from the future.";
    $type = "danger";
    require "message.php";
}

$Database->insert("UPDATE bloods
SET patientBloodResultNumber = ?, patientID = ?, patientBloodTakenDate = ?, patientPlasmaCreatinine = ?
WHERE patientID = ?;",
    array("sisdi", $resultsNumber, $patientCHI, $date, $plasmaCreatinine, $patientCHI));

header('Location: ' . $_SERVER['HTTP_REFERER']);