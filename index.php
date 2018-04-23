<?php
require "header.php";
$Session->isUserLoggedIn();

require "lib/Database.php";
$Database = new Database(); // create an instance of database
?>

<div class="container">
    <h1>Current Gentamicin Patients</h1>

    <table class="table table-responsive table-sm table-striped">
        <thead>
        <tr>
            <th scope="col">#CHI</th>
            <th scope="col">Name</th>
            <th scope="col">Next Dosage</th>
            <th scope="col">Date Due</th>
            <th scope="col">Time Due</th>
            <th scope="col">Gentamicin Dosage</th>
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
<!--        <tr>-->
<!--            <th scope="row"><a href="patient.php?chi=1234567890">1234567890</a></th>-->
<!--            <td>Steven Doe</td>-->
<!--            <td>1h 39m</td>-->
<!--            <td>14/09/2018</td>-->
<!--            <td>17:05</td>-->
<!--            <td>150mg</td>-->
<!--            <td>-->
<!--                <button type="button" class="btn btn-primary btn-sm" data-chi="2" data-toggle="modal" data-target="#dosageGivenModal">Dosage Given</button>-->
<!--            </td>-->
<!--        </tr>-->
        </tbody>
    </table>

    <?php require "dosagegivenmodal.php"; ?>
</div>

<script src="js/formChecker.js"></script>

<?php require "footer.html" ?>