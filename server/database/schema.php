<?php

require('../config.php');

class Subscriptions
{
    static function up($conn): void
    {
        $sql = "
            create table subscriptions (
                id bigint primary key auto_increment,
                email varchar(255) unique not null,
                domain varchar(255) not null,
                created_at timestamp default current_timestamp
            );
        ";

        if ($conn->query($sql))
        {
            echo "Created table 'subscriptions'.";
        } else {
            echo "Error while creating table 'subscriptions': ".$conn->error;
        }
    }

    static function down($conn): void
    {
        $sql = "
            drop table if exists subscriptions;
        ";

        if ($conn->query($sql))
        {
            echo "Dropped table 'subscriptions'.";
        } else {
            echo "Error while dropping table 'subscriptions': ".$conn->error;
        }
    }
}

function schema_up($conn): void
{
    Subscriptions::up($conn);
}

function schema_down($conn): void
{
    Subscriptions::down($conn);
}

if (count($argv) > 1)
{
    $conn = $db_instance->get_connection();
    switch ($argv[1]) {
        case '-up':
            schema_up($conn);
            break;
        
        case '-down':
            schema_down($conn);
            break;

        default:
            echo "Use with '-up' or '-down'";
            break;
    }
} else echo "Use with '-up' or '-down'";
