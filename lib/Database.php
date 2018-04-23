<?php

class Database {
    private $DB;

    public function __construct () {
        require "../../DbConnect.php";
        $this->DB = $DB;
    }

    function insert($Query, $param) {
        $Stmt = $this->DB->prepare($Query);
        $this->prepareArray($param, $Stmt); // now we need to add references

        return $Stmt and $Stmt->execute() and $Stmt->affected_rows <= 1;
    }

    function select($Query, $param) {
        if ($Stmt = $this->DB->prepare($Query)) { // If the query is in the correct format
            $Result = $this->getResult($param, $Stmt);
            $Row = $Result->fetch_assoc();
            $Stmt->close();

            return $Row;
        }

        return null;
    }

    function selectMany($Query, $param) {
        if ($Stmt = $this->DB->prepare($Query)) { // If the query is in the correct format
            $Result = $this->getResult($param, $Stmt);
            $Stmt->close();

            return $Result;
        }

        return null;
    }

    public function getResult($param, $Stmt) {
        if (!is_null($param)) { // where there are no parameters return
            $this->prepareArray($param, $Stmt);
        }
        $Stmt->execute();

        return $Stmt->get_result();
    }

    public function prepareArray($param, $Stmt) {
        $tmp = array();
        foreach ($param as $key => $value) $tmp[$key] = &$param[$key];
        call_user_func_array(array($Stmt, 'bind_param'), $tmp);
    }
}