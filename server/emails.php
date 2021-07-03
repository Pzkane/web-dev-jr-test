<?php

require('config.php');
require('utils.php');
require('database/querybuilder.php');

if ($DEBUG)
{
    header('Access-Control-Allow-Origin', '*');
    header('Access-Control-Allow-Methods: *');
}

$type = $_GET['type'];

$conn = $db_instance->get_connection();

if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
    $email_ids = (isset($_POST['email_ids'])) ? json_decode($_POST['email_ids']) : null;
    if ($email_ids !== null)
    {
        $p_stmt = (new QueryBuilder)
            ->select("*")
            ->from("subscriptions")
            ->where("id in (".implode(", ", $email_ids).")")
            ->prepare($conn, false);

        if ($p_stmt->execute())
        {
            $result = array();
            foreach ($p_stmt->get_result() as $row) {
                array_push($result, $row);
            }
            echo array_to_csv_format($result, ",");
        } else {
            echo_response($p_stmt->error(), "error");
        }
        $p_stmt->close();
    } else {
        echo_response("No IDs provided", "error");
    }
    return;
}


if ($_SERVER['REQUEST_METHOD'] === 'GET')
{
    $type = $_GET['type'];

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
    $domain = (isset($_GET['domain'])) ? $_GET['domain'] : null;

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

    if ($domain !== null)
    {
        $p_stmt = $p_stmt->where("domain = '".$domain."'");
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
}

if ($_SERVER['REQUEST_METHOD'] === 'DELETE')
{
    $email_id = (isset($_GET['id'])) ? $_GET['id'] : null;
    if ($email_id !== null)
    {
        $p_stmt = (new QueryBuilder)
            ->delete()
            ->from("subscriptions")
            ->where("id = '".$email_id."'")
            ->prepare($conn, false);

        if ($p_stmt->execute())
        {
            echo_response("Email deleted. ".$p_stmt->affected_rows);
        } else {
            echo_response($p_stmt->error(), "error");
        }
        $p_stmt->close();
    } else {
        echo_response("No ID provided", "error");
    }
    return;
}
