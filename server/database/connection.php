<?php

class Database
{
    private $DBHOST = "localhost";
    private $DBUSERNAME = "root";
    private $DBPASSWORD = "";
    private $DBNAME = "web_dev_email";

    protected $conn;

    function __construct()
    {
        $connection = new mysqli($this->DBHOST, $this->DBUSERNAME, $this->DBPASSWORD, $this->DBNAME);
        if ($connection->connect_error)
        {
            die("Connection failed: ".$connection->connect_error);
        }

        $this->conn = $connection;
        return $this->get_connection();
    }

    function get_connection()
    {
        return $this->conn;
    }

}