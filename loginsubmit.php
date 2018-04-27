<?php
require "lib/Database.php";

$staffID = $_POST["username"];
$password = $_POST["password"];

$Database = new Database();

$row = $Database->select("SELECT staffID, staffRole
FROM staff
WHERE staffID=?
AND staffPassword=?",
    array("is", $staffID, $password));

if ($row) {
    require "lib/Session.php";
    $Session = new Session();
    $Session->start();

    $_SESSION["Login"] = true;
    $_SESSION["StaffID"] = $row["staffID"];
    $_SESSION["StaffRole"] = $row["staffRole"];
    header("Location: index.php");
} else {
    header("Location: login.php");
}