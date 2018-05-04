<?php
// logout the user
require "lib/Session.php";
$Session = new Session();
$Session->logout();