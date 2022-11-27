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
            for (var i=0; i < table.rows('.selected').data().length; i++) {
                ID = table.rows('.selected').data()[i][1];
                console.log(ID);
            }
            ftch('PATCH', '/api/table_api.php', '')
            e.preventDefault();
        });
    });

</script>