<?php
$cont = 'this'; // Ignore file warnings
// Mode
try {
    switch ($_SERVER['REQUEST_METHOD']) {
        // addToTable
        case 'POST':
            break;

        // deleteFromTable
        case 'DELETE':
            break;

        // updateTable
        case 'PATCH':
            break;

        // Error
        default:
            outputStatus(2, 'Invalid Mode');
    }
} catch (Exception $e) {
    $message = $e->getMessage();
    $$cont->view->outputStatus(2, $message);
}