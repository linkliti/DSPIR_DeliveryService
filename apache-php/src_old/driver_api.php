<?php
// Mode
try {
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'POST':
            selectForDelivery($json);
            break;
        case 'DELETE':
            unselectForDelivery();
            break;
        case 'PATCH':
            markDelivered();
            break;
        case 'GET':
            getTable($json);
            break;
        default:
            outputStatus(2, 'Invalid Mode');
    }
} catch (Exception $e) {
    $message = $e->getMessage();
    outputStatus(2, $message);
}

function selectForDelivery($json)
{
}

function unselectForDelivery()
{

}

function markDelivered()
{
}
function getTable($json)
{

}
?>