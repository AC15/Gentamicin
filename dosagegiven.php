<?php
$date = $_POST["date"];
$time = $_POST["time"];
$dosage = $_POST["dosage"];
$ward = $_POST["ward"];
$person = $_POST["person"];
$patientCHI = $_POST["patientCHI"];

$datetime = $date . " " . $time . ":00";

echo $patientCHI;