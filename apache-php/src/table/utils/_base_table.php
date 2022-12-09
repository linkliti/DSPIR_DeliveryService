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
    width: 1.5rem;
    height: 1.5rem;
    margin-top: 1rem;
  }

  tfoot {
    display: table-header-group;
  }

  tfoot input {
    min-width: 3rem;
    height: 1.5rem;
  }
</style>

<!-- Table JS -->
<script type="text/javascript">
  $(document).ready(function () {
    // Setup - add a text input to each footer cell
    $('#example tfoot th').each(function () {
      var title = $(this).text();
      $(this).html('<input class="form-control" type="text" placeholder="" />');
    });
    table = $('#example').DataTable({
      initComplete: function () {
        // Apply the search
        this.api()
          .columns()
          .every(function () {
            var that = this;

            $('input', this.footer()).on('keyup change clear', function () {
              if (that.search() !== this.value) {
                that.search(this.value).draw();
              }
            });
          });
      },
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
      "search": {
        "regex": true
      },
      'order': [[1, 'asc']]
    });

    // Handle form submission event
    $('#frm-example').on('submit', function (e) {
      e.preventDefault();
    });
    $('tfoot').each(function () {
      $(this).insertAfter($(this).siblings('thead'));
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
      foreach ($table_headers_show as $header) {
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
        if (!$ignore_first) { // ignore first entry
          $entry = array_values($entry); // remove data type
          array_unshift($entry, $entry[0]); // dupe row ID for checkboxes
          echo "<tr>";
          for ($i = 0; $i < count($entry); $i++) {
            echo "<td>" . $entry[$i] . "</td>"; // Add all data in entry to table
          }
          echo "</tr>";
        } else
          $ignore_first = false;
      }
    } else {
      echo '';
    }
    ?>
  </tbody>
  <tfoot class="table">
    <tr>
      <?php
      foreach ($table_headers_show as $header) {
        echo "<th>" . $header . "</th>";
      }
      ?>
    </tr>
  </tfoot>
</table>
<hr>
</form>
</div>