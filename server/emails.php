<?php

require('config.php');
require('utils.php');
require('database/querybuilder.php');

if ($_SERVER['REQUEST_METHOD'] !== 'GET') return;

$conn = $db_instance->get_connection();

$p_stmt = (new QueryBuilder)
    ->select("*")
    ->from("subscriptions")
    ->prepare($conn, false);

if ($p_stmt->execute())
{
    $result = array();
    foreach ($p_stmt->get_result() as $row) {
        array_push($result, $row);
    }
    echo echo_response($result, "records");
} else {
    echo_response($p_stmt->error(), "error");
}

return;
