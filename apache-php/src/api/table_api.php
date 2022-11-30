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
            $table = strstr($json["table"], '.', true) ?: '';
            if ($table) {
                // Check if ids exists
                foreach ($json["data"]["ids"] as $id) {
                    $message = $$cont->model->checkIDinTable($table, $id);
                    if ($message == null) {
                        $$cont->view->outputStatus(1, 'Missing ID: '.$id);
                        return;
                    }
                }
                // Delete them
                $message = array();;
                foreach ($json["data"]["ids"] as $id) {
                    array_push($message, $$cont->model->deleteFromTable($table, $id));
                }
                $$cont->view->outputStatus(0, 'Deleted from '. $table . ' Entries: ' . implode(',', $message));
            }
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