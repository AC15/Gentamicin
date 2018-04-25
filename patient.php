<?php
require "header.php";
$Session->isUserLoggedIn();

require "lib/Database.php";
$Database = new Database(); // create an instance of database

$patientID = htmlspecialchars($_GET["chi"]);

$patientData = $Database->select("SELECT *
FROM patientinfo
WHERE patientID = ?",
    array("i", $patientID));
?>

    <div class="container">
        <h1>Gentamicin Dose Administration</h1>
<?php
if (!$patientData) {
    echo '<div class="alert alert-danger" role="alert">
              Patient with CHI number #' . $patientID . ' does not exist.
            </div>';
    exit(); // stops the php execution
}
?>
        <table class="table table-responsive table-sm">
            <thead>
            <tr>
                <th scope="col">#CHI</th>
                <th scope="col">Name</th>
                <th scope="col">Date of Birth</th>
                <th scope="col">Age</th>
                <th scope="col">Weight</th>
                <th scope="col">Sex</th>
                <th scope="col">Height</th>
            </tr>
            </thead>
            <tbody>
            <tr>
<?php
$dob = $patientData["patientDOB"];
$age = date_diff(date_create($dob), date_create("today"))->y; // converts dob to age
$dob = date("d/m/Y", strtotime($dob)); // formats date from y-m-d to d/m/y

echo "          <td>" . $patientData["patientID"] . "</td>
                <td>" . $patientData["patientFirstName"] . " " . $patientData["patientLastName"] . "</td>
                <td>" . $dob . "</td>
                <td>" . $age . "</td>
                <td>" . $patientData["patientWeight"] . "kg</td>
                <td>" . $patientData["patientGender"] . "</td>
                <td>" . $patientData["patientHeight"] . "cm</td>";
?>
            </tr>
            </tbody>
        </table>

        <br>

        <h3>Serum Gentamicin Levels</h3>
<?php
$bloodResults = $Database->selectMany("SELECT *
FROM bloods
WHERE patientID = ?",
    array("i", $patientID));

if (mysqli_num_rows($bloodResults) == 0) {
    echo '<div class="alert alert-info" role="alert">
              Input blood test results to calculate the gentamicin dosage.
            </div>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-chi="' . $patientID . '" data-target="#bloodTestResultsModal">Input Blood Test Results</button>';
    require "bloodtestmodal.php";
    require "footer.html";
    exit(); // stops the php execution
}
?>
        <table class="table table-responsive table-sm" style="margin-bottom: 0">
            <thead>
            <tr>
                <th scope="col">Results Number</th>
                <th scope="col">Blood Taken On</th>
                <th scope="col">Results (mg/l)</th>
<!--                <th scope="col">Gentamicin Dosage</th>-->
                <th></th>
            </tr>
            </thead>
            <tbody>
<?php
while ($row = $bloodResults->fetch_assoc()) {
    echo '      <tr>
                <td>' . $row["patientBloodResultNumber"] . '</td>
                <td>' . $row["patientBloodTakenDate"] . '</td>
                <td>' . $row["patientPlasmaCreatinine"] . '</td>
                
                <td><form method="post" action="prescription.php">
                    <button type="submit" class="btn btn-primary btn-sm" name="patientCHI" value="' . $patientID . '">Print Prescription</button>
                </form></td>
                </tr>';
}
?>
<!--                <td>200mg</td>-->
            </tr>
            </tbody>
        </table>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-chi="<?php echo $patientID ?>" data-target="#bloodTestResultsModal">Input Blood Test Results</button>

        <br>
        <br>
        <br>

        <h3>Next Dosage</h3>
        <table class="table table-responsive table-sm">
            <thead>
            <tr>
                <th scope="col">Next Dosage</th>
                <th scope="col">Date Due</th>
                <th scope="col">Gentamicin Dosage</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <tr>
<?php
$dosagesDue = $Database->select("SELECT *
FROM dosagesdue
WHERE patientID = ?",
    array("i", $patientID));

$dosageDueDate = date("d/m/Y h:i", strtotime($dosagesDue["patientDosageDue"])); // formats date from y-m-d to d/m/y
$date1 = new DateTime("now");
$date2 = new DateTime($dosagesDue["patientDosageDue"]);

// The diff-methods returns a new DateInterval-object...
$diff = $date2->diff($date1);

// Call the format method on the DateInterval-object
$timeRemaining = $diff->format('%h:%i:%s');

if ($timeRemaining <= 0) {
    $timeRemaining = "DUE";
}

echo '  <td>' . $timeRemaining . '</td>
        <td>' . $dosageDueDate . '</td>
        <td>' . $dosagesDue["patientDosage"] . 'mg</td>
        <td><button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-chi="'. $patientID . '" data-target="#dosageGivenModal">Dosage Given</button></td>';
?>
            </tr>
            </tbody>
        </table>

        <br>

        <h3>Previous Dosages</h3>
        <p>Initial Gentamicin Dose: <?php echo $dosagesDue["patientDosage"] ?>mg</p>
        <p>Predicted Frequency: <?php echo $dosagesDue["patientDosageHourlyRate"] ?> hourly</p>

<?php
$previousDosages = $Database->selectMany("SELECT recordDosageGivenDate, recordDosageDue, recordDosageGivenAmount, recordDosageGivenBy, recordDoseGivenWard, staffTitle, staffID, staffTitle, staffFirstName, staffLastName
FROM records
LEFT JOIN staff ON recordDosageGivenBy = staffID
WHERE patientID = ?",
    array("i", $patientID));

if (mysqli_num_rows($previousDosages) > 0) {
    echo '        <table class="table table-responsive table-sm table-striped">
                <thead>
                <tr>
                    <th scope="col">Date Due</th>
                    <th scope="col">Date Given</th>
                    <th scope="col">Dosage</th>
                    <th scope="col">Ward</th>
                    <th scope="col">Given By #</th>
                    <th scope="col">Given By</th>
                </tr>
                </thead>
                <tbody>';

    while ($row = $previousDosages->fetch_assoc()) {
        $name = $row["staffTitle"] . " " . $row["staffFirstName"] . " " . $row["staffLastName"];

        echo '<tr>
            <td>' . $row["recordDosageDue"] . '</td>
            <td>' . $row["recordDosageGivenDate"] . '</td>
            <td>' . $row["recordDosageGivenAmount"] . '</td>
            <td>' . $row["recordDoseGivenWard"] . '</td>
            <td>' . $row["recordDosageGivenBy"] . '</td>
            <td>' . $name . '</td>
        </tr>';
    }
    echo '            </tbody>
        </table>';
} else {
    echo '<div class="alert alert-info" role="alert">
              Currently there are no previous dosages.
            </div>';
}
?>

        <br>

        <h3>Stop Gentamicin Treatment</h3>
        <p>Remove all scheduled gentamicin dosages for this patient.</p>
        <form method="post" action="stoptreatment.php">
            <button type="submit" class="btn btn-primary" data-toggle="modal" name="patientCHI" value="<?php echo $patientID ?>">Stop Gentamicin Treatment</button>
        </form>

        <?php require "dosagegivenmodal.php"; ?>

        <?php require "bloodtestmodal.php"; ?>

    </div>

<?php require "footer.html" ?>