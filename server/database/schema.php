<?php

require('connection.php');

$db_instance = new Database;
$conn = $db_instance->get_connection();

function schema_subscriptions($conn)
{
    $sql = "
        create table subscriptions (
            id bigint primary key auto_increment,
            email varchar(255) not null,
            created_at timestamp default current_timestamp
        );
    ";

    if ($conn->query($sql))
    {
        echo "Table 'subscriptions' created.";
    } else {
        echo "Error while creating table 'subscriptions': ".$conn->error;
    }
}


schema_subscriptions($conn);
