<?php

require('config.php');
require('utils.php');
require('database/querybuilder.php');

if ($_SERVER['REQUEST_METHOD'] !== 'GET') return;

$type = $_GET['type'];

$conn = $db_instance->get_connection();

if ($type === "domains")
{
    $p_stmt = (new QueryBuilder)
        ->select("domain")
        ->from("subscriptions")
        ->groupBy("domain")
        ->prepare($conn, false);

    if ($p_stmt->execute())
    {
        $result = array();
        foreach ($p_stmt->get_result() as $row) {
            array_push($result, $row["domain"]);
        }
        echo_response($result, "domains");
    } else {
        echo_response($p_stmt->error, "error");
    }
    return;
}


$column = (isset($_GET['orderByColumn'])) ? $_GET['orderByColumn'] : null;
$order = (isset($_GET['orderBy'])) ? $_GET['orderBy'] : null;
$offset = (isset($_GET['offset'])) ? $_GET['offset'] : null;
$pagination = (isset($_GET['pagination'])) ? $_GET['pagination'] : null;

$p_stmt = (new QueryBuilder)
    ->select("*")
    ->from("subscriptions");

if ($column !== null)
{
    $p_stmt = $p_stmt->orderBy($column, $order);
}

if ($pagination !== null)
{
    $p_stmt = $p_stmt->limit($pagination, $offset);
}

$p_stmt = $p_stmt->prepare($conn, false);

if ($p_stmt->execute())
{
    $result = array();
    foreach ($p_stmt->get_result() as $row) {
        array_push($result, $row);
    }
    echo_response($result, "records");
} else {
    echo_response($p_stmt->error(), "error");
}

$p_stmt->close();

return;
