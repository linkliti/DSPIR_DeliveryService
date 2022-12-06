<?php
// is user allowed to VIEW
if (!checkPrivilege($privilege['VIEW'])) {
  require_once getFileFromRoot('/table/utils/_access_denied_msg.php');
  return;
}
// Container
echo '<div class="container-lg pt-4"><form id="frm-example"><p>';
if (checkPrivilege($privilege['POST'])) {
  require_once getFileFromRoot('/table/utils/_add_form.php');
  echo '<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">Добавить</button>';
}
if (checkPrivilege($privilege['PATCH'])) {
  require_once getFileFromRoot('/table/utils/_modify_form.php');
  echo '<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updateModal">Обновить</button>';
}
if (checkPrivilege($privilege['DELETE'])) {
  require_once getFileFromRoot('/table/utils/_delete_form.php');
  echo '<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#deleteModal">Удалить</button>';
}
echo '</p>';