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

<script type="text/javascript">
  $(document).ready(function () {
    var table = $('#example').DataTable({
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
      var form = this;

      var rows_selected = table.column(0).checkboxes.selected();

      // Iterate over all selected checkboxes
      $.each(rows_selected, function (index, rowId) {
        // Create a hidden element
        $(form).append(
          $('<input>')
            .attr('type', 'hidden')
            .attr('name', 'id[]')
            .val(rowId)
        );
      });

      // FOR DEMONSTRATION ONLY
      // The code below is not needed in production

      // Output form data to a console
      $('#example-console-rows').text(rows_selected.join(","));

      // Output form data to a console
      $('#example-console-form').text($(form).serialize());

      // Remove added elements
      $('input[name="id\[\]"]', form).remove();

      // Prevent actual form submission
      e.preventDefault();
    });
  });

</script>

<div class="container-lg pt-4">
  <form id="frm-example" action="/path/to/your/script.php" method="POST">
    <table id="example" class="table table-bordered table-striped dataTable dt-checkboxes-select" cellspacing="0" width="100%">
      <thead class="table-dark">
        <tr>
          <th></th>
          <th>ID</th>
          <th>Name</th>
          <th>Position</th>
          <th>Office</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>1</td>
          <td>1</td>
          <td>Brenden Wagner</td>
          <td>Software Engineer</td>
          <td>San Francisco</td>
        </tr>
        <tr>
          <td>2</td>
          <td>2</td>
          <td>Brenden Wagner</td>
          <td>Software Engineer</td>
          <td>San Francisco</td>
        </tr>
      </tbody>
    </table>
    <hr>

    <p>Press <b>Submit</b> and check console for URL-encoded form data that would be submitted.</p>

    <p><button>Submit</button></p>

    <p><b>Selected rows data:</b></p>
    <pre id="example-console-rows"></pre>

    <p><b>Form data as submitted to the server:</b></p>
    <pre id="example-console-form"></pre>

  </form>
</div>