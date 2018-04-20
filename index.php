<?php
require "header.php";
$Session->isUserLoggedIn();
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
        <tr>
            <th scope="row"><a href="patient.php?chi=1234567890">1234567890</a></th>
            <td>John Doe</td>
            <td>Due</td>
            <td>15/09/2018</td>
            <td>17:00</td>
            <td>200mg</td>
            <td>
                <button type="button" class="btn btn-primary btn-sm" data-chi="1" data-toggle="modal" data-target="#dosageGivenModal">Dosage Given</button>
            </td>
        </tr>
        <tr>
            <th scope="row"><a href="patient.php?chi=1234567890">1234567890</a></th>
            <td>Steven Doe</td>
            <td>1h 39m</td>
            <td>14/09/2018</td>
            <td>17:05</td>
            <td>150mg</td>
            <td>
                <button type="button" class="btn btn-primary btn-sm" data-chi="2" data-toggle="modal" data-target="#dosageGivenModal">Dosage Given</button>
            </td>
        </tr>
        <tr>
            <th scope="row"><a href="patient.php?chi=1234567890">1234567890</a></th>
            <td>Jack Doe</td>
            <td>2d 1h 39m</td>
            <td>14/09/2018</td>
            <td>17:05</td>
            <td>160mg</td>
            <td>
                <button type="button" class="btn btn-primary btn-sm" data-chi="3" data-toggle="modal" data-target="#dosageGivenModal">Dosage Given</button>
            </td>
        </tr>
        </tbody>
    </table>

    <?php require "dosagegivenmodal.html"; ?>
</div>

<script src="js/formChecker.js"></script>

<?php require "footer.html" ?>