<link rel="stylesheet" type="text/css" href="/css/library/dataTables.checkboxes.css" />
<link rel="stylesheet" type="text/css" href="/css/library/dataTables.bootstrap5.min.css" />
<link rel="stylesheet" type="text/css" href="/css/library/select.bootstrap5.min.css" />

<script type="text/javascript" src="/js/library/jquery-3.6.1.min.js"></script>
<script type="text/javascript" src="/js/library/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="/js/library/dataTables.bootstrap5.min.js"></script>
<script type="text/javascript" src="/js/library/dataTables.select.min.js"></script>
<script type="text/javascript" src="/js/library/dataTables.checkboxes.min.js"></script>

<style type="text/css">
  .dt-checkboxes {
    width: 1em;
    height: 1em;
    margin-top: .25em;
  }
</style>

<!-- Table JS -->
<script type="text/javascript">
  $(document).ready(function () {
    table = $('#example').DataTable({
      'columnDefs': [
        {
          'targets': 0,
          'checkboxes': {
            'selectRow': true,
            'selectAll': false
          }
        }
      ],
      dom: '<lf<rt>ip>',
      'language': {
        url: '//cdn.datatables.net/plug-ins/1.13.1/i18n/ru.json'
      },
      'select': {
        'style': 'multi'
      },
      'order': [[1, 'asc']]
    });

    // Handle form submission event
    $('#frm-example').on('submit', function (e) {
      e.preventDefault();
    });
  });
  function getSelectedIDs() {
    var selected = [];
    for (var i = 0; i < table.rows('.selected').data().length; i++) {
      ID = table.rows('.selected').data()[i][1];
      selected.push(ID);
    }
    return selected;
  }
</script>

<!-- Table -->
<table id="example" class="table table-bordered table-striped dataTable dt-checkboxes-select" cellspacing="0" width="100%">
  <thead class="table-dark">
    <tr>
      <?php
      foreach ($table_headers as $header) {
        echo "<td>" . $header . "</td>";
      }
      ?>
    </tr>
  </thead>
  <tbody>
    <?php
    $tableData = 'table'; // ignore error
    if ($$tableData->num_rows > 0) {
      foreach ($$tableData as $entry) {
        echo "<tr>";
        foreach ($table_data as $data) {
          echo "<td>" . $entry[$data] . "</td>";
        }
        echo "</tr>";
      }
    } else {
      echo '';
    }
    ?>
  </tbody>
</table>
<hr>
</form>
</div>