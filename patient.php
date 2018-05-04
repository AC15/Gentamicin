<?php
require "header.php";
$Session->isUserLoggedIn();

require "lib/Database.php";
$Database = new Database(); // create an instance of database

$patientID = htmlspecialchars($_GET["chi"]);

// queries patient data from the database
$patientData = $Database->select("SELECT *
FROM patientinfo
WHERE patientID = ?",
    array("i", $patientID));
?>

    <div class="container">
        <h1>Gentamicin Dose Administration</h1>
<?php
if (!$patientData) { // display an error message if query was not successful
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

        <h3>Serum Creatinine Levels</h3>
<?php
// selects all blood records for a patients
$bloodResults = $Database->selectMany("SELECT *
FROM bloods
WHERE patientID = ?
ORDER BY patientBloodResultNumber",
    array("i", $patientID));

// if query was not successful display a message to input blood test results
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
                <th></th>
            </tr>
            </thead>
            <tbody>
<?php
// display the blood test results on the screen
while ($row = $bloodResults->fetch_assoc()) {
    $bloodTestDate = new DateTime($row["patientBloodTakenDate"]);
    $bloodTestDate = $bloodTestDate->format('d/m/Y');

    echo '      <tr>
                <td>' . $row["patientBloodResultNumber"] . '</td>
                <td>' . $row["patientBloodTakenDate"] . '</td>
                <td>' . $row["patientPlasmaCreatinine"] . '</td>
                <td><button type="button" class="btn btn-primary btn-sm" data-date="' . $bloodTestDate . '" data-number="' . $row["patientBloodResultNumber"] . '" data-plasma="' . $row["patientPlasmaCreatinine"] . '" data-toggle="modal" data-chi="" data-target="#editBloodTestResultsModal">Edit</button></td>
                </tr>';
}
?>
            </tr>
            </tbody>
        </table>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-chi="<?php echo $patientID ?>" data-target="#bloodTestResultsModal">Input Blood Test Results</button>

<?php
// Hides the calculated dosages from the view of other users than Doctors and when there are no dosages due
if ($Session->getStaffRole() != "Doctor") {
    require "bloodtestmodal.php";
    require "footer.html";
    exit();
}
?>

        <br>
        <br>

<?php
// selects dosage due
$dosagesDue = $Database->select("SELECT *
FROM dosagesdue
WHERE patientID = ?",
    array("i", $patientID));

$isPatientNotTreated = !is_null($dosagesDue["patientDosage"]);

// display dosage due if it exists
if ($isPatientNotTreated) {
    echo '        <br>
        <h3>Next Dosage</h3>
        <p>Initial Gentamicin Dose: ' . $dosagesDue["patientDosage"] . 'mg</p>
        <p>Predicted Frequency: ' . $dosagesDue["patientDosageHourlyRate"] . ' hourly</p>
        <table class="table table-responsive table-sm">
            <thead>
            <tr>
                <th scope="col">Next Dosage</th>
                <th scope="col">Date Due</th>
                <th scope="col">Gentamicin Dosage</th>
                <th></th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <tr>';

    $dosageDueDate = new DateTime($dosagesDue["patientDosageDue"]);
    $currentDate = new DateTime("now");

    $formattedDosageDueDate = $dosageDueDate->format('D, d M Y H:i:s O'); // this date format is required for the counter to work in IE
    $formattedDateDue = $dosageDueDate->format('d/m/Y H:i:s');

    echo '  <td><p id="dosageDueCounter"></p></td>
        <td>' . $formattedDateDue . '</td>
        <td>' . $dosagesDue["patientDosage"] . 'mg</td>
        <td><button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-chi="' . $patientID . '" data-target="#dosageGivenModal">Dosage Given</button></td>
        <td><form method="post" action="prescription.php">
            <button type="submit" class="btn btn-primary btn-sm" name="patientCHI" value="' . $patientID . '">Print Prescription</button>
        </form></td>
            </tr>
            </tbody>
        </table>';
}
?>
        <br>

        <h3>Previous Gentamicin Dosages</h3>
<?php
// displays all previous dosages on the screen
$previousDosages = $Database->selectMany("SELECT recordDosageGivenDate, recordDosageDue, recordDosageGivenAmount, recordDosageGivenBy, recordDoseGivenWard, staffTitle, staffID, staffTitle, staffFirstName, staffLastName
FROM records
LEFT JOIN staff ON recordDosageGivenBy = staffID
WHERE patientID = ?
ORDER BY recordDosageDue",
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
        $formattedDateDue = date("d/m/Y h:i", strtotime($row["recordDosageDue"])); // formats date from y-m-d to d/m/y
        $formattedDateGiven = date("d/m/Y h:i", strtotime($row["recordDosageGivenDate"])); // formats date from y-m-d to d/m/y

        echo '<tr>
            <td>' . $formattedDateDue . '</td>
            <td>' . $formattedDateGiven . '</td>
            <td>' . $row["recordDosageGivenAmount"] . '</td>
            <td>' . $row["recordDoseGivenWard"] . '</td>
            <td>' . $row["recordDosageGivenBy"] . '</td>
            <td>' . $name . '</td>
        </tr>';
    }
    echo '            </tbody>
        </table>';
} else { // display a message when there are no dosages due
    echo '<div class="alert alert-info" role="alert">
              Currently there are no previous dosages.
            </div>';
}

// display the stop gentamicin treatment button when patient is treated
if ($isPatientNotTreated) {
    echo '        <br>
        
        <h3>Stop Gentamicin Treatment</h3>
        <p>Remove all scheduled gentamicin dosages for this patient.</p>
        <td><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#stopTreatmentModal">Stop Gentamicin Treatment</button></td>';
}
?>

        <script src="js/formChecker.js"></script>
        <script src="js/timer.js"></script>
        <script>
            var countDownDate = new Date("<?php echo $formattedDosageDueDate ?>").getTime();
            timer(countDownDate, "dosageDueCounter");
        </script>

        <?php require "dosagegivenmodal.php"; ?>

        <?php require "editbloodtestmodal.php"; ?>

        <?php require "bloodtestmodal.php"; ?>

        <?php require "stoptreatmentmodal.php"; ?>

    </div>

<?php require "footer.html" ?>