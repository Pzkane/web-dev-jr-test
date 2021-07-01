<?php

class Database
{
    protected $conn;

    function __construct($db_host, $db_username, $db_password, $db_name)
    {
        $connection = new mysqli($db_host, $db_username, $db_password, $db_name);
        if ($connection->connect_error)
        {
            die("Connection failed: ".$connection->connect_error);
        }

        $this->conn = $connection;
        return $this->get_connection();
    }

    function __destruct()
    {
        $this->conn->close();
    }

    function get_connection(): object
    {
        return $this->conn;
    }
}
