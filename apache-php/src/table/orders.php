<?php
$table_headers = array('', 'ID доставки', 'ID позиции', 'ID клиента', 'ID ПВЗ', 'ID Сборщика', 'Сумма', 'Дата доставки', 'Статус');
$table_data = array('id_Order', 'id_Order', 'Warehouse_id_Position', 'Clients_id_Client', 'PVZ_id_PVZ', 'Workers_id_Worker', 'DeliveryAmount', 'DeliveryDateTime', 'DeliveryStatus');
?>

<div class="container-lg pt-4">
  <form id="frm-example">
    <p>
    <button type="button" class="btn btn-primary" onclick="deleteOrder()">Удалить</button>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">Добавить</button>
    <button type="button" class="btn btn-primary" onclick="updateOrder()">Обновить</button>
    </p>
    <?php
    require_once getFileFromRoot('/table/_add_form.php');
    require_once getFileFromRoot('/table/_base_table.php');
    ?>

    <script type="text/javascript">
      function deleteOrder() {
        selected = getSelectedIDs();
        if (selected.length > 1) {
          ftch('DELETE', '/api/manager_api.php', '{"id": [' + selected.join(',') + ']}')
        }
      }
      function addOrder() {
        selected = getSelectedIDs();
        if (selected.length > 1) {
          ftch('DELETE', '/api/manager_api.php', '{"id": [' + selected.join(',') + ']}')
        }
      }
      function updateOrder() {
        selected = getSelectedIDs();
        if (selected.length > 1) {
          ftch('DELETE', '/api/manager_api.php', '{"id": [' + selected.join(',') + ']}')
        }
      }
    </script>