<?php

class Session {
    private $isLoggedIn;
    private $staffID;

    public function __construct() {
        if (!$this->isLoggedIn) {
            $this->start();
        }

        $this->isLoggedIn = $_SESSION["Login"];
        $this->staffID = $_SESSION["UserID"];
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
        $_SESSION["UserID"] = false;
        header("Location: index.php");
    }

    public function getLoggedIn() {
        return $this->isLoggedIn;
    }

    public function getStaffID() {
        return $this->staffID;
    }
}