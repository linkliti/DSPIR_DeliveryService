<?php
// Mode
try {
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'POST':
            addToTable($json);
            break;
        case 'DELETE':
            deleteFromTable($json);
            break;
        case 'PATCH':
            updateTable($json);
            break;
        default:
            outputStatus(2, 'Invalid Mode');
    }
} catch (Exception $e) {
    $message = $e->getMessage();
    outputStatus(2, $message);
}

function addToTable($json) {

}
function deleteFromTable($json) {

}
function updateTable($json) {

}
