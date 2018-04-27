<?php

class Session {
    private $isLoggedIn;
    private $staffID;
    private $staffRole;

    public function __construct() {
        if (!$this->isLoggedIn) {
            $this->start();
        }

        $this->isLoggedIn = $_SESSION["Login"];
        $this->staffID = $_SESSION["StaffID"];
        $this->staffRole = $_SESSION["StaffRole"];
    }

    /**
     * Starts the php session
     */
    function start() {
        session_start();
    }

    /**
     * Checks if user is logged in, if not, it sends him to the login form
     */
    function isUserLoggedIn() {
        if (!$this->isLoggedIn) {
            header("Location: login.php");
        }
    }

    /**
     * Logs out the user
     */
    function logout() {
        $this->start();
        $_SESSION["Login"] = false;
        $_SESSION["StaffID"] = false;
        $_SESSION["StaffRole"] = false;
        header("Location: index.php");
    }

    public function getLoggedIn() {
        return $this->isLoggedIn;
    }

    public function getStaffID() {
        return $this->staffID;
    }

    public function getStaffRole() {
        return $this->staffRole;
    }
}