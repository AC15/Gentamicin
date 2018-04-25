<?php
$resultsNumber = $_POST["resultsNumber"];
$patientCHI = $_POST["patientCHI"];
$date = $_POST["date"];
$plasmaCreatinine = $_POST["plasmaCreatinine"];

require "lib/Database.php";
$Database = new Database(); // create an instance of database

echo $resultsNumber, $patientCHI, $date, $plasmaCreatinine;

// insert results to the blood table
$Database->insert("INSERT INTO bloods VALUES (?, ?, ?, ?)",
    array("sisd", $resultsNumber, $patientCHI, $date, $plasmaCreatinine));

// select dosage information if it exists
$dosageInfo = $Database->select("SELECT *
FROM dosagesdue
WHERE patientID = ?",
    array("i", $patientCHI));

if ($dosageInfo) {
    $dose = $dosageInfo["patientDosage"];
    $hourlyRate = $dosageInfo["patientDosageHourlyRate"];
} else {
    $sex = "M";
    $age = 44;
    $height = 155;
    $weight = 155;
    $plasmaCreatinine = 44;

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
//
//    // add the initial dosage to the table
//    $Database->insert("INSERT INTO dosage VALUES (?, ?, ?)",
//        array("idi", $patientCHI, $dose, $hourlyRate));
}


//$date = date('Y-m-d H:i', strtotime("now +1 hour"));

$Database->insert("INSERT INTO dosagesdue VALUES (?, CURRENT_TIMESTAMP, ?, ?)",
    array("iii", $patientCHI, $hourlyRate, $dose));

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

function validate() {
    global $age;
    global $creatinineClearance;
    global $height;
    global $weight;
    global $plasmaCreatinine;

    if ($age > 70 && $age <= 16
        && $creatinineClearance < 20
        && ($height < 100) || ($height > 250)
        && is_null($age) && is_null($height) && is_null($weight) && is_null($plasmaCreatinine)) {
        return false;
    }
    return true;
}

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

header('Location: ' . $_SERVER['HTTP_REFERER']);