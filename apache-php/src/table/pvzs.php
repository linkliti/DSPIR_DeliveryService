<?php
$table_headers = array('', 'ID ПВЗ', 'Наименование', 'Адрес', 'Колво сотрудников', 'Расписание');

?>

<div class="container-lg pt-4">
  <?php
  require_once getFileFromRoot('/table/utils/_table_data.php');
  $table_data = getTableFormData(currentFile());
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