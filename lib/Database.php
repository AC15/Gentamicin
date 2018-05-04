<?php

class Database {
    private $DB;

    public function __construct () {
        require "../../DbConnect.php";
        $this->DB = $DB;
    }

    /**
     * Inserts a query into the database
     *
     * @param $Query
     * @param $param
     * @return bool
     */
    function insert($Query, $param) {
        $Stmt = $this->DB->prepare($Query);
        $this->prepareArray($param, $Stmt); // now we need to add references

        return $Stmt and $Stmt->execute() and $Stmt->affected_rows <= 1;
    }

    /**
     * Fetches one row from the database
     *
     * @param $Query
     * @param $param
     * @return null
     */
    function select($Query, $param) {
        if ($Stmt = $this->DB->prepare($Query)) { // If the query is in the correct format
            $Result = $this->getResult($param, $Stmt);
            $Row = $Result->fetch_assoc();
            $Stmt->close();

            return $Row;
        }

        return null;
    }

    /**
     * Fetches many rows from the database
     *
     * @param $Query
     * @param $param
     * @return mixed|null
     */
    function selectMany($Query, $param) {
        if ($Stmt = $this->DB->prepare($Query)) { // If the query is in the correct format
            $Result = $this->getResult($param, $Stmt);
            $Stmt->close();

            return $Result;
        }

        return null;
    }

    /**
     * Gets the result of a query
     *
     * @param $param
     * @param $Stmt
     * @return mixed
     */
    public function getResult($param, $Stmt) {
        if (!is_null($param)) { // where there are no parameters return
            $this->prepareArray($param, $Stmt);
        }
        $Stmt->execute();

        return $Stmt->get_result();
    }

    /**
     * Prepares the query before it's being executed
     *
     * @param $param
     * @param $Stmt
     */
    public function prepareArray($param, $Stmt) {
        $tmp = array();
        foreach ($param as $key => $value) $tmp[$key] = &$param[$key];
        call_user_func_array(array($Stmt, 'bind_param'), $tmp);
    }
}