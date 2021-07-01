<?php

require('config.php');
require('utils.php');
require('database/querybuilder.php');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') return;

if (!isset($_POST['email']))
{
    echo_response("Email address is required", "error");
    return;
}

$email = htmlspecialchars($_POST['email']);

if (preg_match('/^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.co)|(([a-zA-Z\-0-9]+\.)+co))$/i', $email))
{
    echo_response("We are not accepting subscriptions from Colombia emails", "error");
    return;
}

if (!preg_match('/^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/i', $email))
{
    echo_response("Please provide a valid e-mail address", "error");
    return;
}

$conn = $db_instance->get_connection();

$p_stmt = (new QueryBuilder)
    ->insert('subscriptions', 'email')
    ->values('?')
    ->prepare($conn)
    ->bind("s", $email);

if ($p_stmt->execute())
{
    echo_response();
} else {
    if (preg_match('/Duplicate/', $p_stmt->error))
    {
        echo_response("This e-mail is already subscribed", "error");
    } else {
        echo_response("Error", "error");
    }
}

$p_stmt->close();

return;
