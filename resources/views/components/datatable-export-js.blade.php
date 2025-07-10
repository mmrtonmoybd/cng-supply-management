<script>
// Usage: window.initExportableDataTable('#yourTableId');
window.initExportableDataTable = function(tableSelector) {
    if($(tableSelector).length > 0) {
        var now = new Date();
        var dateStr = now.getFullYear() + '-' + 
                     (now.getMonth()+1).toString().padStart(2, '0') + '-' + 
                     now.getDate().toString().padStart(2, '0') + '_' + 
                     now.getHours().toString().padStart(2, '0') + 
                     now.getMinutes().toString().padStart(2, '0') + 
                     now.getSeconds().toString().padStart(2, '0');
        var fileName = 'datatable-export-' + dateStr;

        $(tableSelector).DataTable({
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'colvis',
                    text: 'Toggle Columns',
                    postfixButtons: ['colvisRestore']
                },
                {
                    extend: 'excelHtml5',
                    title: 'Filter Results',
                    filename: fileName,
                    exportOptions: { columns: ':visible' },
                    footer: true
                },
                {
                    extend: 'pdfHtml5',
                    title: 'Filter Results',
                    filename: fileName,
                    exportOptions: { columns: ':visible' },
                    footer: true,
                    orientation: 'landscape',
                    pageSize: 'A3',
                    customize: function (doc) {
                        doc.pageMargins = [10, 10, 10, 10];
                        doc.defaultStyle.fontSize = 6;
                        doc.styles.tableHeader.fontSize = 7;
                        var body = doc.content[1].table.body;
                        var colCount = body[0].length;
                        doc.content[1].table.widths = Array(colCount).fill('*');
                        body.forEach(function(row) {
                            row.forEach(function(cell) {
                                if (typeof cell === 'object') {
                                    cell.fontSize = 6;
                                }
                            });
                        });
                    }
                },
                {
                    extend: 'print',
                    title: 'Filter Results',
                    exportOptions: { columns: ':visible' },
                    footer: true,
                    customize: function (win) {
                        $(win.document.body).css('font-size', '10pt');
                        $(win.document.body).find('table')
                            .addClass('compact')
                            .css('font-size', 'inherit');
                    }
                }
            ],
            paging: false,
            searching: false,
            ordering: false,
            info: false
        });
    }
};
</script>
