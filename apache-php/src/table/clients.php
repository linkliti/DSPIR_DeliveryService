<?php
$table_headers = array('', 'ID клиента', 'ФИО', 'Тел Номер', 'Почта', 'Тип');
$table_data = array('id_Client', 'id_Client', 'Fullname', 'PhoneNumber', 'Email', 'ClientType');
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