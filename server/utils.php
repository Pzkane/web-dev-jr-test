<?php

function echo_response($msg = "success", ?string $type = "success"): void
{
    $er_arr[$type] = $msg;
    header('Content-type: application/json');
    echo json_encode($er_arr);
}

function array_to_csv_format($array, $delimiter=";") {
    $csv = "";
    foreach ($array as $line) {
        $csv .= implode($delimiter, $line) . "\n";
    }
    return $csv;
}