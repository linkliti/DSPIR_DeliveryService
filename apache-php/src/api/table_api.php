<?php
$cont = 'this'; // Ignore file warnings
// Mode
try {
  switch ($_SERVER['REQUEST_METHOD']) {
    // addToTable
    case 'POST':
      $table = strstr($json["table"], '.', true) ?: '';
      if ($table) {
        require getFileFromRoot('/table/utils/_table_data.php');
        $table_data = getTableFormData($json["table"]);
        $table_data = array_values(array_slice($table_data, 2));
        // Check if table headers correct
        if (array_keys($json["data"]) === $table_data) {
          $$cont->model->addToTable($table, array_values($json["data"]), $table_data);
          $$cont->view->outputStatus(0, 'Added entry to table ' . $table);
          return;
        } else {
          $$cont->view->outputStatus(1, 'Wrong table structure');
        }
      } else {
        $$cont->view->outputStatus(1, 'Missing table data');
      }
      return;

    // deleteFromTable
    case 'DELETE':
      $table = strstr($json["table"], '.', true) ?: '';
      if ($table) {
        $ids = $json["data"]["ids"];
        // Check if ids exists
        if (!($$cont->checkIDArray($ids, $table))) {
          return;
        }
        // Delete entries
        $$cont->model->deleteFromTable($table, $ids);
        $$cont->view->outputStatus(0, 'Deleted entries from ' . $table);
      } else {
        $$cont->view->outputStatus(1, 'Missing table data');
      }
      return;

    // updateTable
    case 'PATCH':
      $table = strstr($json["table"], '.', true) ?: '';
      if ($table) {
        require getFileFromRoot('/table/utils/_table_data.php');
        $table_data = getTableFormData($json["table"]);
        $table_data = array_values(array_slice($table_data, 2));
        $var = $json["data"]["var"];
        $val = $json["data"]["val"];
        $ids = $json["data"]["ids"];
        // Check if data is correct
        if (in_array($var, $table_data, true) and isset($val) and is_array($ids)) {
          // Check if ids exists
          if (!($$cont->checkIDArray($json["data"]["ids"], $table))) {
            return;
          }
          $$cont->model->updateTable($table, $var, $val, $ids);
          $$cont->view->outputStatus(0, 'Updated entries in ' . $table);
          return;
        } else {
          $$cont->view->outputStatus(1, 'Wrong data structure');
        }
      } else {
        $$cont->view->outputStatus(1, 'Missing table data');
      }
      return;

    // Error
    default:
      $$cont->view->outputStatus(2, 'Invalid Mode');
      return;
  }
} catch (Exception $e) {
  $message = $e->getMessage();
  $$cont->view->outputStatus(2, $message);
}