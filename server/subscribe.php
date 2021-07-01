<?php

require('config.php');

function echo_response(string $msg = "success", string $type = "success")
{
    $er_arr[$type] = $msg;
    echo json_encode($er_arr);
}

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

$p_stmt = $conn->prepare("insert into subscriptions (email) values (?)");
$p_stmt->bind_param("s", $email);

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
