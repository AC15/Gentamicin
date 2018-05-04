<?php
require "lib/Database.php";
$Database = new Database(); // create an instance of database

require "lib/Session.php";
$Session = new Session();
$patientCHI = $_POST["patientCHI"];
$staffID = $Session->getStaffID();

// seelects patient and dosage due information
$patient = $Database->select("SELECT patientinfo.patientID, patientDOB, patientFirstName, patientLastName, patientDosageDue, patientDosage
FROM dosagesdue
LEFT JOIN patientinfo ON patientinfo.patientID = dosagesdue.patientID
WHERE patientinfo.patientID = ?",
    array("i", $patientCHI));

// selects staff details
$staff = $Database->select("SELECT CONCAT(staffTitle, '. ', staffFirstName, ' ', staffLastName) AS staffName
FROM staff
WHERE staffID = ?",
    array("i", $staffID));

$dob = date("d/m/Y", strtotime($patient["patientDOB"])); // formats date from y-m-d to d/m/y
?>
<link rel="stylesheet" href="css/bootstrap.min.css">

<style>
    .table {
        max-width: 400px;
        margin-bottom: 0;
    }
</style>

<table class="table table-bordered">
    <thead>
    <tr>
        <th scope="col">
            <p>Patient Name: <?php echo $patient["patientFirstName"] . " " . $patient["patientLastName"] ?></p>
            <p>Date of Birth: <?php echo $dob ?></p>
            <p>CHI: 32641</p>
        </th>
    </tr>
    </thead>
</table>

<table class="table table-bordered">
    <thead>
    <tr>
        <th scope="col" style="text-align: center">Medication Required</th>
    </tr>
    </thead>
</table>

<table class="table table-bordered">
    <thead>
    <tr>
        <th scope="col">Name</th>
        <th scope="col">Strength</th>
        <th scope="col">Quantity</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>Gentamicin</td>
        <td><?php echo $patient["patientDosage"] ?>mg</td>
        <td>1</td>
    </tr>
    </tbody>
</table>

<table class="table table-bordered">
    <thead>
    <tr>
        <th scope="col">
            <p>Doctor's Name: <?php echo $staff["staffName"] ?></p>
            <p>Registration No: <?php echo $staffID ?></p>
            <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Signature: ________________________</p>
        </th>
    </tr>
    </thead>
</table>

<script>
    window.print(); // prints the prescription
    setTimeout(window.close, 0); // this will close the page when user clicks on cancel (edge does not work)
</script>