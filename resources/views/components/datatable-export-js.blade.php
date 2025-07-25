@php
$default = 'Filter Results';

if (request()->is('transport-filter/show')) {
    $default = request()->filled('vehicle_id')
        ? \App\Models\Vehicle::find(request()->vehicle_id)?->vehicle_number . ' Filter Results'
        : 'Transport Filter Results';

} elseif (request()->is('load-filter/show')) {
    $default = request()->filled('pumpName_id') || request()->filled('car_no')
        ? \App\Models\PumpName::find(request()->pumpName_id)?->name . ' ' . request()->car_no . ' Load Filter Results'
        : 'Load Filter Results';

} elseif (request()->is('pump-filter/show')) {
    $default = request()->filled('pumpName_id') || request()->filled('car_no')
        ? \App\Models\PumpName::find(request()->pumpName_id)?->name . ' ' . request()->car_no . ' Pump Filter Results'
        : 'Pump Filter Results';

} elseif (request()->is('pump-summary/result')) {
    $default = 'Pump Summary Results';

} elseif (request()->is('diesel-summary')) {
    $default = 'Diesel Summary Results';

} elseif (request()->is('transport-summary/show')) {
    $default = 'M/S Musafir Motors Summary';

} elseif (request()->is('diesel-filter')) {
    $default = request()->filled('pumpName_id') || request()->filled('car_no')
        ? \App\Models\PumpName::find(request()->pumpName_id)?->name . ' ' . request()->car_no . ' Diesel Filter Results'
        : 'Diesel Filter Results';

} elseif (request()->is('vehicleincome-filter/show')) {
    $default = request()->filled('pumpName_id') || request()->filled('car_no')
        ? \App\Models\PumpName::find(request()->pumpName_id)?->name . ' ' . request()->car_no . ' Vehicle Income Filter Results'
        : 'Vehicle Income Filter Results';

} elseif(request()->is('factory/dispansar-filter/show')) {
    $default = request()->filled('pumpName_id') || request()->filled('car_no') || request()->filled('factory_id')
        ? \App\Models\Factory::find(request()->factory_id)?->name . ' '. \App\Models\PumpName::find(request()->pumpName_id)?->name . ' ' . request()->car_no . ' Filter Results'
        : 'Dispansar Filter Results';
} elseif(request()->is('factory/weightone-filter/show')) {
    $default = request()->filled('pumpName_id') || request()->filled('car_no') || request()->filled('factory_id')
        ? \App\Models\Factory::find(request()->factory_id)?->name . ' '. \App\Models\PumpName::find(request()->pumpName_id)?->name . ' ' . request()->car_no . ' Filter Results'
        : 'Cng Pump & Weight Scale Filter Results';
    } elseif(request()->is('factory/weight-filter/show')) {
    $default = request()->filled('pumpName_id') || request()->filled('car_no') || request()->filled('factory_id')
        ? \App\Models\Factory::find(request()->factory_id)?->name . ' '. \App\Models\PumpName::find(request()->pumpName_id)?->name . ' ' . request()->car_no . ' Filter Results'
        : 'Weight Filter Filter Results';
    } elseif(request()->is('factory/cngPump-filter/show')) {
    $default = request()->filled('pumpName_id') || request()->filled('car_no') || request()->filled('factory_id')
        ? \App\Models\Factory::find(request()->factory_id)?->name . ' '. \App\Models\PumpName::find(request()->pumpName_id)?->name . ' ' . request()->car_no . ' Filter Results'
        : 'Cng Pump Slip Filter Results';
    } elseif (request()->is('factory/factory-summary/result')) {
    $default = 'Factory Summary Results';

    } elseif (request()->is('transport-filter/show')) {
    $default =  request()->filled('vehicle_id')
        ? \App\Models\Vehicle::find(request()->vehicle_id)?->vehicle_number . ' Filter Results'
        : 'Transport Filter Results';
    }
@endphp


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
        var fileName = '{{ $default }}-export-' + dateStr;

        $(tableSelector).DataTable({
            dom: 'Bfrtip',
            stateSave: true,
            stateDuration: 60 * 60 * 24 * 365 * 10,

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
                    title: '{{ $default }}',
                    filename: fileName,
                    exportOptions: { columns: ':visible' },
                    footer: true,
                    orientation: 'landscape',
                    pageSize: 'A3',
                    customize: function (doc) {
                        doc.pageMargins = [10, 10, 10, 10];
                        doc.defaultStyle.fontSize = 6;
                        doc.styles.tableHeader.fontSize = 7;

                        // Center the title
                        doc.content.splice(0, 1, {
                            text: '{{ $default }}',
                            style: 'header',
                            alignment: 'center',
                            fontSize: 12,
                            margin: [0, 0, 0, 12]
                        });

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
                    title: '{{ $default }}',
                    exportOptions: { columns: ':visible' },
                    footer: true,
                    customize: function (win) {
                        $(win.document.body).css('font-size', '10pt');
                        $(win.document.body).find('table')
                            .addClass('compact')
                            .css('font-size', 'inherit');

                        // Center the title
                        $(win.document.body).find('h1').css({
                            'text-align': 'center',
                            'font-size': '18pt',
                            'margin-bottom': '10px'
                        });
                    }

                }
                @if(request()->is('vehicleincome-filter/show'))
                 ,{
            text: 'Summary Print',
            className: 'btn btn-primary', // Bootstrap style
            action: function (e, dt, node, config) {
                const dateRange = '{{ request('date_range') }}'; // Blade variable (ensure it's escaped correctly)
                const url = "{{ route('backend.vehicleIncome.showFilterPrint') }}?pumpName_id={{ request('pumpName_id') }}&car_no={{ request('car_no') }}&date_range={{ request('date_range') }}";
                window.open(url, '_blank');
                 } 
             }
                @endif
            ],
            paging: false,
            searching: false,
            ordering: false,
            info: false
        });
    }
};
</script>
