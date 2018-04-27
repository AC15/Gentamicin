<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/custom.css">
    <link href="css/font-awesome.min.css">

    <title>Gentamicin App</title>
</head>
<body>
<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
    <a class="navbar-brand" href="index.php">Gentamicin App</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbar">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="index.php">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="calculator.php">Calculator</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="about.php">About Gentamicin</a>
            </li>
        </ul>
<?php
date_default_timezone_set("Europe/London"); // sets the timezone to uk time

require "lib/Session.php";
$Session = new Session();

if ($Session->getLoggedIn()) {
    echo '<form class="form-inline my-lg-0 mr-2" method="get" action="patient.php">
            <div class="input-group">
                <input type="number" id="chi" class="form-control" name="chi" placeholder="Search by #CHI" required>
                <button class="btn btn-outline-light my-2 my-sm-0" type="submit">
                    <span class="fa fa-search"></span>
                </button>
            </div>
        </form>
        <a href="logout.php" class="btn btn-outline-light my-2 my-sm-0" role="button">
            <span class="fa fa-sign-out"></span> Logout
        </a>';
} else {
    echo '<a href="login.php" class="btn btn-outline-light my-2 my-sm-0" role="button">
            <span class="fa fa-sign-in"></span> Login
        </a>';
}
?>
    </div>
</nav>