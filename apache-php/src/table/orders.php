<?php
$table_headers = array('', 'ID доставки', 'ID позиции', 'ID клиента', 'ID ПВЗ', 'ID Сборщика', 'Сумма', 'Дата доставки', 'Статус');
$table_data = array('id_Order', 'id_Order', 'Positions_id_Position', 'Clients_id_Client', 'PVZs_id_PVZ', 'Workers_id_Worker', 'DeliveryAmount', 'DeliveryDateTime', 'DeliveryStatus');
?>

<div class="container-lg pt-4">
  <?php
  require_once getFileFromRoot('/table/_add_form.php');
  require_once getFileFromRoot('/table/_modify_form.php');
  require_once getFileFromRoot('/table/_delete_form.php');
  ?>
  <form id="frm-example">
    <p>
      <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#deleteModal">Удалить</button>
      <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">Добавить</button>
      <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updateModal">Обновить</button>
    </p>
    <?php
    require_once getFileFromRoot('/table/_base_table.php');
    ?>