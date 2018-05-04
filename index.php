<?php
require "header.php";
$Session->isUserLoggedIn();

require "lib/Database.php";
$Database = new Database(); // create an instance of database
?>

<script src="js/timer.js"></script>

<div class="container">
<?php
if ($Session->getStaffRole() == "Doctor") { // if a doctor is logged in
    echo '<h1>Gentamicin Dosages Due</h1>';

    // display dosages due
    $dosagesDue = $Database->selectMany("SELECT patientinfo.patientID, patientFirstName, patientLastName, patientDosageDue, patientDosage
    FROM dosagesdue
    LEFT JOIN patientinfo ON patientinfo.patientID = dosagesdue.patientID
    ORDER BY patientDosageDue",
        null);

    if (mysqli_num_rows($dosagesDue) > 0) {
        echo '<table class="table table-responsive table-sm table-striped">
        <thead>
        <tr>
            <th scope = "col" >#CHI</th>
            <th scope = "col" > Name</th>
            <th scope = "col" > Next Dosage </th>
            <th scope = "col" > Date Due </th>
            <th scope = "col" > Gentamicin Dosage </th>
            <th></th>
            <th></th>
        </tr>
        </thead>
        <tbody>';

        for ($i = 0; $row = $dosagesDue->fetch_assoc(); $i++) {
            $dosageDueDate = new DateTime($row["patientDosageDue"]);
            $formattedDate = date("d/m/Y h:i", strtotime($row["patientDosageDue"])); // formats date from y-m-d to d/m/y
            $formattedDosageDueDate = $dosageDueDate->format("D, d M Y H:i:s O"); // this date format is required for the counter to work in IE

            echo '<tr>
            <th scope="row"><a href="patient.php?chi=' . $row["patientID"] . '">' . $row["patientID"] . '</a></th>
            <td>' . $row["patientFirstName"] . ' ' . $row["patientLastName"] . '</td>
            <td><div id="timer' . $i . '"></div></td>
            <td>' . $formattedDate . '</td>
            <td>' . $row["patientDosage"] . 'mg</td>
            <td><button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-chi="' . $row["patientID"] . '" data-target="#dosageGivenModal">Dosage Given</button></td>
            <td><form method="post" action="prescription.php">
                <button type="submit" class="btn btn-primary btn-sm" name="patientCHI" value="' . $row["patientID"] . '">Print Prescription</button>
            </form></td>
            </tr>';

            echo '<script>
                    var countDownDate = new Date("' . $formattedDosageDueDate . '").getTime();
                    timer(countDownDate, "timer' . $i . '");
                </script>';
        }
    } else { // if there are no dossages due display an info message
        echo '<div class="alert alert-info" role="alert">
              Currently there are no dosages due.
            </div>';
    }
}
?>
        </tbody>
    </table>

    <h1>All Gentamicin Patients</h1>

    <table class="table table-responsive table-sm table-striped">
        <thead>
        <tr>
            <th scope="col">#CHI</th>
            <th scope="col">Name</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
<?php
// display patients data
$patientData = $Database->selectMany("SELECT patientID, patientFirstName, patientLastName
FROM patientinfo
ORDER BY patientID", null);

while ($row = $patientData->fetch_assoc()) {
    echo '        <tr>
    <th scope="row"><a href="patient.php?chi=' . $row["patientID"] . '">' . $row["patientID"] . '</a></th>
    <td>' . $row["patientFirstName"] . ' ' . $row["patientLastName"] . '</td>
    
</tr>';
}
?>
        </tbody>
    </table>

    <?php require "dosagegivenmodal.php"; ?>
</div>

<script src="js/formChecker.js"></script>

<?php require "footer.html" ?>