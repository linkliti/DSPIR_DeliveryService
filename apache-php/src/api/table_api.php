<?php
$cont = 'this'; // Ignore file warnings
// Deny not authorised requests
if (!isset($_SESSION['role'])) {
  $$cont->view->outputStatus(1, 'Not authorised');
  return;
}
// Mode
try {
  switch ($_SERVER['REQUEST_METHOD']) {
    // addToTable
    case 'POST':
      $table = strstr($json["table"], '.', true) ?: '';
      if ($table) {
        require getFileFromRoot('/table/utils/_table_data.php');
        $table_data = array_values(array_slice($table_data, 1));
        /* Data checks */
        // Check privileges
        if (!$$cont->checkPrivilege($_SESSION['role'], $privilege['POST']))
          return;
        // Check if table headers correct
        if (array_keys($json["data"]) === $table_data) {
          // Transform date
          if ($table == 'orders' and $json["data"]["DeliveryDate"])
            $json["data"]["DeliveryDate"] = $$cont->transformDate($json["data"]["DeliveryDate"]);
          // Encrypt passwords
          if ($table == 'workers')
            $json["data"]["User_pass"] = $$cont->encryptPass($json["data"]["User_pass"]);
          // Finally updating table
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
        require getFileFromRoot('/table/utils/_table_data.php');
        $ids = $json["data"]["ids"];
        /* Data checks */
        // Preserve service rows
        if ($ignore_first and in_array(1, $ids)) {
          $$cont->view->outputStatus(1, 'Cannot modify service row with ID 1');
          return;
        }
        // Check privileges
        if (!$$cont->checkPrivilege($_SESSION['role'], $privilege['DELETE']))
          return;
        // Check if ids exists
        if (!$$cont->checkIDArray($ids, $table)) {
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
        $table_data = array_values(array_slice($table_data, 1));
        $var = $json["data"]["var"];
        $val = $json["data"]["val"];
        $ids = $json["data"]["ids"];
        /* Data checks */
        // Preserve service rows
        if ($ignore_first and in_array(1, $ids)) {
          $$cont->view->outputStatus(1, 'Cannot modify service row with ID 1');
          return;
        }
        // Check privileges
        if (!$$cont->checkPrivilege($_SESSION['role'], $privilege['PATCH']))
          return;
        // Check if data is correct
        if (in_array($var, $table_data, true) and isset($val) and is_array($ids)) {
          // Check if ids exists in array
          if (!$$cont->checkIDArray($ids, $table)) {
            return;
          }
          // Encrypt passwords
          if ($table == 'workers' and $var == 'User_pass')
            $val = $$cont->encryptPass($val);
          // Transform date
          if ($table == 'orders' and $var == "DeliveryDate")
            $val = $$cont->transformDate($val);
          // Finally updating table
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