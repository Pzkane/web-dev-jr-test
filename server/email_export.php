<?php
require('config.php');
require('utils.php');
require('database/querybuilder.php');

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