<?php
require "lib/Database.php";
$Database = new Database(); // create an instance of database

$date = $_POST["date"];
$resultsNumber = $_POST["resultsNumber"];
$plasmaCreatinine = $_POST["plasmaCreatinine"];
$patientCHI = $_POST["patientCHI"];
$oldResultsNumber = $_POST["oldResultsNumber"];

date_default_timezone_set("Europe/London"); // sets the timezone to uk time
$date = DateTime::createFromFormat("d/m/Y", $date);
$date = $date->format("Y-m-d");

// Displays an error when a date from the future is inputted
if (new DateTime("today") < new DateTime($date)) {
    $message = "You cannot input a date from the future.";
    $type = "danger";
    require "message.php";
}

// updates blood test result
$updateBloodTest = $Database->insert("UPDATE bloods
SET patientBloodResultNumber = ?, patientBloodTakenDate = ?, patientPlasmaCreatinine = ?
WHERE patientBloodResultNumber = ? AND patientID = ?",
    array("ssdsi", $resultsNumber, $date, $plasmaCreatinine, $oldResultsNumber, $patientCHI));

// Displays an error when insert to blood table is not correct
if (!$updateBloodTest) {
    $message = "An error occurred. Please check if a record with the same result number was not already entered.";
    $type = "danger";
    require "message.php";
}

// redirects user to the previous page
header('Location: ' . $_SERVER['HTTP_REFERER']);