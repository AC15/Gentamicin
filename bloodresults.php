<?php
$resultsNumber = $_POST["resultsNumber"];
$patientCHI = $_POST["patientCHI"];
$date = $_POST["date"];
$plasmaCreatinine = $_POST["plasmaCreatinine"];

date_default_timezone_set("Europe/London"); // sets the timezone to uk time
$date = DateTime::createFromFormat("d/m/Y", $date);
$date = $date->format("Y-m-d");

// Displays an error when a date from the future is inputted
if (new DateTime("today") < new DateTime($date)) {
    $message = "You cannot input a date from the future.";
    $type = "danger";
    require "message.php";
}

require "lib/Database.php";
$Database = new Database(); // create an instance of database

// select dosage information if it exists
$dosageInfo = $Database->select("SELECT *
FROM dosagesdue
WHERE patientID = ?",
    array("i", $patientCHI));

// Displays an error when a date from the future is inputted
if (new DateTime("today") < new DateTime($date)) {
    $message = "You cannot input a date from the future.";
    $type = "danger";
    require "message.php";
}

if ($dosageInfo) { // if blood results were given take the values and continue
    $dose = $dosageInfo["patientDosage"];
    $hourlyRate = $dosageInfo["patientDosageHourlyRate"];
} else { // if not then calculate the dosage
    $patientInfo = $Database->select("SELECT patientWeight, patientHeight, patientGender, patientDOB
    FROM patientinfo
    WHERE patientID = ?",
            array("i", $patientCHI));

    $dob = $patientInfo["patientDOB"];
    $age = date_diff(date_create($dob), date_create("today"))->y; // converts dob to age

    $sex = $patientInfo["patientGender"];
    $height = $patientInfo["patientHeight"];
    $weight = $patientInfo["patientWeight"];

    $hourlyRate = 0;
    $dose = 0;
    $x = 0;
    $f = 0;

    if ($sex === "M") {
        $x = 50;
        $f = 1.23;
    } else if ($sex === "F") {
        $x = 45.5;
        $f = 1.04;
    }

    $ibw = calculateIBW();

    if ($weight > $ibw) {
        $weight = $ibw;
    }

    // Check creatinine clearance
    $a = (140 - $age) * $weight * $f;
    $creatinineClearance = $a / $plasmaCreatinine;

    if (validate()) {
        if ($creatinineClearance > 60) {
            dosage(24, 400, 360, 320, 280, 240);
        }
        else if ($creatinineClearance >= 51) {
            dosage(24, 320, 300, 280, 240, 200);
        }
        else if ($creatinineClearance >= 41) {
            dosage(48, 400, 360, 320, 280, 240);
        }
        else if ($creatinineClearance >= 31) {
            dosage(48, 320, 300, 280, 240, 200);
        }
        else if ($creatinineClearance >= 21) {
            dosage(48, 260, 240, 240, 200, 180);
        }
    }
}

// insert results to the blood table
$insertBlood = $Database->insert("INSERT INTO bloods VALUES (?, ?, ?, ?)",
    array("sisd", $resultsNumber, $patientCHI, $date, $plasmaCreatinine));

// Displays an error when insert to blood table is not correct
if (!$insertBlood) {
    $message = "An error occurred. Please check if a record with the same result number was not already entered.";
    $type = "danger";
    require "message.php";
}

// If a dosage is already due, it won't add it
$Database->insert("INSERT INTO dosagesdue VALUES (?, CURRENT_TIMESTAMP, ?, ?)",
    array("iii", $patientCHI, $hourlyRate, $dose));

// calculates ideal body weight
function calculateIBW() {
    global $height;
    global $x;

    $ft_dif = 0;
    // How far over 5ft
    if ($height > 152.4) {
        $cm_dif = $height - 152.4;
        $inchsum = $cm_dif * 0.39370;

        $ft_dif = 60 - $inchsum; // Find difference from 5ft (60 inches)
    }

    // Find ideal body weight
    return $x + (2.3 * $ft_dif);
}

// validates the inputs and displays an error message
function validate() {
    global $age;
    global $creatinineClearance;
    global $height;
    global $weight;
    global $plasmaCreatinine;

    $message = "";

    if ($age > 70) {
        $message = "The patient is too old to receive gentamicin treatment.";
    } else if ($age < 17) {
        $message = "The patient is too young to receive gentamicin treatment.";
    } else if ($creatinineClearance < 20) {
        $message = "The creatine clearance needs to be above 20.";
    } else if ($height < 100) {
        $message = "The patient is too short to receive gentamicin treatment.";
    } else if ($height > 250) {
        $message = "The patient is too tall to receive gentamicin treatment.";
    } else if (is_null($age)
        || is_null($height)
        || is_null($weight)
        || is_null($plasmaCreatinine)) {
        $message = "There is not enough data to calculate the dosage.";
    }

    if ($message !== "") {
        $type = "danger";
        require "message.php";
    }

    return true;
}

// calculates the dosage
function dosage($hourly_rate, $dose1, $dose2, $dose3, $dose4, $dose5) {
    global $hourlyRate;
    global $weight;
    global $dose;

    $hourlyRate = $hourly_rate;

    if ($weight > 80) {
        $dose = $dose1;
    }
    else if ($weight >= 70) {
        $dose = $dose2;
    }
    else if ($weight >= 60) {
        $dose = $dose3;
    }
    else if ($weight >= 50) {
        $dose = $dose4;
    }
    else if ($weight >= 40) {
        $dose = $dose5;
    }
}

// redirects user to the previous page
header('Location: ' . $_SERVER['HTTP_REFERER']);