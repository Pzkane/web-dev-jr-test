<?php

require('config.php');
require('utils.php');
require('database/querybuilder.php');

if ($DEBUG)
{
    header('Access-Control-Allow-Origin', '*');
    header('Access-Control-Allow-Methods: *');
}

$conn = $db_instance->get_connection();

if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
    $type = $_POST['type'];

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

    $column = (isset($_POST['orderByColumn'])) ? $_POST['orderByColumn'] : null;
    $order = (isset($_POST['orderBy'])) ? $_POST['orderBy'] : null;
    $offset = (isset($_POST['offset'])) ? $_POST['offset'] : null;
    $pagination = (isset($_POST['pagination'])) ? $_POST['pagination'] : null;
    $domain = (isset($_POST['domain']) && $_POST['domain'] !== "") ? $_POST['domain'] : null;
    $email_string = (isset($_POST['emailString'])) ? $_POST['emailString'] : null;

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

    if ($email_string !== null)
    {
        $p_stmt = $p_stmt->where("email like '%".$email_string."%'");
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
