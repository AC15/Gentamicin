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
        <h1>Gentamicin Information</h1>
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
            <tr>
<?php
$bloodResults = $Database->selectMany("SELECT *
FROM bloods
WHERE patientID = ?",
    array("i", $patientID));

while ($row = $bloodResults->fetch_assoc()) {
    echo '                <td>' . $row["patientBloodResultNumber"] . '</td>
                <td>' . $row["patientBloodTakenDate"] . '</td>
                <td>' . $row["patientPlasmaCreatinine"] . '</td>
    
                <td><a class="btn btn-primary btn-sm" href="prescription.php" role="button">Print Prescription</a></td>';
}
?>
<!--                <td>200mg</td>-->
            </tr>
            </tbody>
        </table>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#bloodTestResultsModal">Input Blood Test Results</button>

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
//$timeRemaining = round((strtotime($dosageDueDate) - strtotime("now")) / 3600, 1);
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
<!--                <td>Due</td>-->
<!--                <td>15/09/2018</td>-->
<!--                <td>17:00</td>-->
<!--                <td>200mg</td>-->
            </tr>
            </tbody>
        </table>

        <br>

        <h3>Previous Dosages</h3>
        <p>Initial Gentamicin Dose: 200mg</p>
        <p>Predicted Frequency: 24 hourly</p>

        <table class="table table-responsive table-sm table-striped">
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
            <tbody>
<?php
$previousDosages = $Database->selectMany("SELECT recordDosageGivenDate, recordDosageDue, recordDosageGivenAmount, recordDosageGivenBy, recordDoseGivenWard, staffTitle, staffID, staffTitle, staffFirstName, staffLastName
FROM records
LEFT JOIN staff ON recordDosageGivenBy = staffID
WHERE patientID = ?",
    array("i", $patientID));

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
?>
            </tbody>
        </table>

        <br>

        <h3>Stop Gentamicin Treatment</h3>
        <p>Remove all scheduled Gentamicin dosages for this patient.</p>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#dosageGivenModal">Stop Gentamicin Treatment</button>

        <?php require "dosagegivenmodal.php"; ?>

        <div class="modal fade" id="bloodTestResultsModal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <form method="post" action="bloodresults.php" id="needs-validation" novalidate>
                        <div class="modal-header">
                            <h5 class="modal-title" id="bloodTestResultsTitle">Blood Test Results</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="date">Blood Taken On</label>
                                <input type="date" class="form-control" id="date" name="date" placeholder="YYYY-MM-DD" required>
                                <div class="invalid-feedback">Please provide a date the blood was received on.</div>
                            </div>
                            <div class="form-group">
                                <label for="resultsNumber">Results Number</label>
                                <input type="text" class="form-control" id="resultsNumber" name="resultsNumber" placeholder="Results Number" required>
                                <div class="invalid-feedback">Please provide a result number.</div>
                            </div>
                            <div class="form-group">
                                <label for="plasmaCreatinine">Plasma Creatinine Level</label>
                                <input type="text" class="form-control" id="plasmaCreatinine" name="plasmaCreatinine" placeholder="Plasma Creatinine Level" required>
                                <div class="invalid-feedback">Please provide a plasma creatinine level.</div>
                            </div>
                            <input type="hidden" id="patientCHI" name="patientCHI" value="<?php echo $patientID ?>"/>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                $('#bloodTestResultsModal').on('show.bs.modal', function (event) {
                    var button = $(event.relatedTarget); // Button that triggered the modal
                    var chi = button.data('chi'); // Extract info from data-* attributes
                    $("#patientCHI").val(chi);
                });
            });
        </script>

    </div>

<?php require "footer.html" ?>