<?php
$date = $_POST["date"];
$time = $_POST["time"];
$ward = $_POST["ward"];
$person = $_POST["person"];
$patientCHI = $_POST["patientCHI"];

date_default_timezone_set("Europe/London"); // sets the timezone to uk time
$date = DateTime::createFromFormat("d/m/Y", $date);
$date = $date->format("Y-m-d");
$datetime = $date . " " . $time . ":00";

// Displays an error when a date from the future is inputted
if (new DateTime("now") < new DateTime($datetime)) {
    $message = "You cannot input a date from the future.";
    $type = "danger";
    require "message.php";
}

require "lib/Database.php";
$Database = new Database(); // create an instance of database

// select dosage due information
$dosageDue = $Database->select("SELECT *
FROM dosagesdue
WHERE patientID = ?",
    array("i", $patientCHI));

// insert dosage to the records table
$Database->insert("INSERT INTO records VALUES (?, ?, ?, ?, ?, ?)",
    array("issiis", $patientCHI, $datetime, $dosageDue["patientDosageDue"], $dosageDue["patientDosage"], $person, $ward));

$dosageDueDate = $date = date('Y-m-d H:i:s', strtotime($datetime) + 3600 * $dosageDue["patientDosageHourlyRate"]);

$Database->insert("UPDATE dosagesdue
SET patientDosageDue = ?
WHERE patientID = ?",
    array("si", $dosageDueDate, $patientCHI));

// redirects user to the previous page
header('Location: ' . $_SERVER['HTTP_REFERER']);