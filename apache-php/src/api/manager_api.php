<?php
// Mode
try {
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'POST':
            addOrder($json);
            break;
        case 'DELETE':
            deleteOrder();
            break;
        case 'PATCH':
            updateOrder();
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

function deleteOrder()
{

}

function updateOrder()
{
}
function getTable($json)
{
    $controller = '$this'; // ignore errors
    $$controller->model->getTable('Manager');
}
?>