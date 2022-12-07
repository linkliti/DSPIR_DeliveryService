<?php
require_once getFileFromRoot('/table/utils/_table_data.php');
// is user allowed to VIEW
if (!checkPrivilege($privilege['VIEW'])) {
    require_once getFileFromRoot('/table/utils/_access_denied_msg.php');
    return;
}
require_once getFileFromRoot('/table/utils/_privilege_check.php');
require_once getFileFromRoot('/table/utils/_base_table.php');
?>