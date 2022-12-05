<?php
if (!checkPrivilege('manager')) {
  require_once getFileFromRoot('/table/utils/_access_denied_msg.php');
  return;
}
require_once getFileFromRoot('/table/utils/_table_data.php');
?>

<div class="container-lg pt-4">
  <?php
  require_once getFileFromRoot('/table/utils/_add_form.php');
  require_once getFileFromRoot('/table/utils/_modify_form.php');
  require_once getFileFromRoot('/table/utils/_delete_form.php');
  ?>
  <form id="frm-example">
    <p>
      <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#deleteModal">Удалить</button>
      <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">Добавить</button>
      <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updateModal">Обновить</button>
    </p>
    <?php
    require_once getFileFromRoot('/table/utils/_base_table.php');
    ?>