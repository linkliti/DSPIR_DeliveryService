<?php
$table_headers =
array('',
'ID доставки',
'ID позиции',
'ID клиента',
'ID ПВЗ',
'ID Сборщика',
'Сумма',
'Дата доставки',
'Статус');
require_once getFileFromRoot('/table/_base_table.php');
?>

<div class="container-lg pt-4">
  <form id="frm-example">
    <table id="example" class="table table-bordered table-striped dataTable dt-checkboxes-select" cellspacing="0" width="100%">
      <thead class="table-dark">
        <tr>
          <?php
          foreach ($table_headers as $header) {
            echo "
              <td>" . $header . "</td>
            ";
          };
          ?>
        </tr>
      </thead>
      <tbody>
        <?php
            $tableData = '$table';
            if ($$tableData->num_rows > 0) {
              foreach ($table as $entry) {
                echo "<tr>
                <td>" . $entry['id_Order'] . "</td>
                <td>" . $entry['id_Order'] . "</td>
                <td>" . $entry['Warehouse_id_Position'] . "</td>
                <td>" . $entry['Clients_id_Client'] . "</td>
                <td>" . $entry['PVZ_id_PVZ'] . "</td>
                <td>" . $entry['Workers_id_Worker'] . "</td>
                <td>" . $entry['DeliveryAmount'] . "</td>
                <td>" . $entry['DeliveryDateTime'] . "</td>
                <td>" . $entry['DeliveryStatus'] . "</td>
                </tr>";
              }
            } else {
              echo '';
            };
          ?>
      </tbody>
    </table>
    <hr>

    <p>Press <b>Submit</b> and check console for URL-encoded form data that would be submitted.</p>

    <p><button onclick="">Submit</button></p>

    <p><b>Selected rows data:</b></p>
    <pre id="example-console-rows"></pre>

    <p><b>Form data as submitted to the server:</b></p>
    <pre id="example-console-form"></pre>

  </form>
</div>