<?php
// Container
echo '<div class="container-lg pt-4"><p>';
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