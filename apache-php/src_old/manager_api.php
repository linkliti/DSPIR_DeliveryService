<?php
// Mode
try {
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'POST':
            addOrder($json);
            break;
        case 'DELETE':
            deleteOrder($json);
            break;
        case 'PATCH':
            updateOrder($json);
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

function addOrder($json)
{
}

function deleteOrder($json)
{

}

function updateOrder($json)
{
}
function getTable($json)
{

}
?>