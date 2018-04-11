<?php
require "lib/Database.php";

$username = $_POST["username"];
$password = $_POST["password"];

$Database = new Database();

$row = $Database->select("SELECT CustomerID
FROM albaUsers
WHERE Email=?
AND Password=?",
    array("ss", $username, $password));

if ($row) {
    require "lib/Session.php";
    $Session = new Session();
    $Session->start();

    $_SESSION["Login"] = true;
    $_SESSION["UserID"] = $row["CustomerID"];
    header("Location: index.php");
} else {
    header("Location: login.php");
}