<?php
require "header.php";
$Session->isUserLoggedIn();

require "lib/Database.php";
$Database = new Database(); // create an instance of database
?>

<div class="container">
    <h1>Gentamicin Dosages Due</h1>
<?php
$dosagesDue = $Database->selectMany("SELECT patientinfo.patientID, patientFirstName, patientLastName, patientDosageDue, patientDosage
FROM dosagesdue
LEFT JOIN patientinfo ON patientinfo.patientID = dosagesdue.patientID",
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
        </tr>
        </thead>
        <tbody>';

    while ($row = $dosagesDue->fetch_assoc()) {
        $dosageDueDate = date("d/m/Y h:i", strtotime($row["patientDosageDue"])); // formats date from y-m-d to d/m/y
        $date1 = new DateTime("now");
        $date2 = new DateTime($row["patientDosageDue"]);

        // The diff-methods returns a new DateInterval-object...
        $diff = $date2->diff($date1);

        // Call the format method on the DateInterval-object
        $timeRemaining = $diff->format('%h:%i:%s');

        if ($timeRemaining <= 0) {
            $timeRemaining = "DUE";
        }

        echo '<tr>
        <th scope="row"><a href="patient.php?chi=' . $row["patientID"] . '">' . $row["patientID"] . '</a></th>
        <td>' . $row["patientFirstName"] . ' ' . $row["patientLastName"] . '</td>
        <td>' . $timeRemaining . '</td>
        <td>' . $dosageDueDate . '</td>
        <td>' . $row["patientDosage"] . 'mg</td>
        <td><button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-chi="' . $row["patientID"] . '" data-target="#dosageGivenModal">Dosage Given</button></td>
        </tr>';
    }
} else {
    echo '<div class="alert alert-info" role="alert">
              Currently there are no dosages due.
            </div>';
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
$patientData = $Database->selectMany("SELECT patientID, patientFirstName, patientLastName
FROM patientinfo", null);

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