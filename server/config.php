<?php

require('database/connection.php');

$DBHOST = "localhost";
$DBUSERNAME = "root";
$DBPASSWORD = "";
$DBNAME = "web_dev_email";

$db_instance = new Database($DBHOST, $DBUSERNAME, $DBPASSWORD, $DBNAME);
return $db_instance;
