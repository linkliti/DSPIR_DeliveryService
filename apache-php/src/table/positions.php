<?php
$table_headers = array('', 'ID позиции', 'Наименование', 'Тип', 'Расположение', 'ID сборщика');
$table_data = array('id_Position', 'id_Position', 'Position', 'PositionType', 'PositionLocation', 'Workers_id_Worker');
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