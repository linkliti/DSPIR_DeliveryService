<?php
// Mode
try {
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'POST':
            addPosition($json);
            break;
        case 'DELETE':
            deletePosition();
            break;
        case 'PATCH':
            updatePosition();
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

function addPosition($json)
{
}

function deletePosition()
{

}

function updatePosition()
{
}
function getTable($json)
{
    $controller = '$this'; // ignore errors
    $$controller->model->getPackageStatus();
}
?>