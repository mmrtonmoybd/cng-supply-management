@extends('boilerplate::layout.index', [
    'title' => 'Invoice Details',
    'subtitle' => 'View Invoice',
])

@section('content')
<div class="row">
    <div class="col-12 pb-3 no-print no-export d-flex justify-content-between align-items-center">
        <a href="{{ route('backend.factory.invoice.index') }}" class="btn btn-default" data-toggle="tooltip" title="Back to list">
            <span class="far fa-arrow-alt-circle-left text-muted"></span> Back
        </a>
         
        <span class="float-right pb-3 mr-2">
        <a href="{{ route('backend.factory.invoice.export', $invoice->id) }}?header=1" target="_blank" class="btn btn-success">
            <i class="fas fa-file-invoice-dollar"></i> Export Invoice(With header)
        </a>
        <a href="{{ route('backend.factory.invoice.export', $invoice->id) }}" target="_blank" class="btn btn-primary">
            <i class="fas fa-file-invoice-dollar"></i> Export Invoice(Without header)
        </a>
        </span>
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-md-12">
        <x-boilerplate::card>
            <h4 class="mb-4">Invoice Information</h4>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr><th>Invoice no: </th><td>{{ $invoice->id }}</td></tr>
                    <tr><th>Invoice date: </th><td>{{ $invoice->date ? (\Carbon\Carbon::parse($invoice->date)->format('d-m-Y')) : 'N/A' }}</td></tr>
                    <tr><th>Factory: </th><td>{{ $invoice->factory->name }}</td></tr>
                    <tr><th>Invoice amount: </th><td>{{ $invoice->total }}</td></tr>
                    <tr><th>Factory type: </th><td>
                        @if ($invoice->factory_type == 'dispansar')
                            Dispansar
                        @elseif($invoice->factory_type == 'weightone')
                            Cng Pump & Weight Scale
                        @elseif($invoice->factory_type == 'cngpump')
                            CNG Pump slip
                        @elseif($invoice->factory_type == 'weight')
                            Weight Scale
                        @endif
                    </td></tr>
                </tbody>
            </table>

            <table class="table table-bordered table-striped mt-4">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Date</th>
                        <th>
                        @if ($invoice->factory_type == 'dispansar')
                            Bill no
                        @elseif($invoice->factory_type == 'weightone')
                            Challan no
                        @elseif($invoice->factory_type == 'cngpump')
                            Bill no
                        @elseif($invoice->factory_type == 'weight')
                            Bill no
                        @endif
                        </th>
                        <th>Vehicle No</th>
                        <th>
                        @if ($invoice->factory_type == 'dispansar')
                            Total Reading
                        @elseif($invoice->factory_type == 'weightone')
                            M3
                        @elseif($invoice->factory_type == 'cngpump')
                            M3
                        @elseif($invoice->factory_type == 'weight')
                            M3
                        @endif
                    </th>
                    <th>Rate</th>
                    <th>Taka</th>
                    <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                        @if ($invoice->factory_type == 'dispansar')
                            @php
                            $items = $invoice->dispansar;
                            @endphp
                        @elseif($invoice->factory_type == 'weightone')
                            @php
                            $items = $invoice->weightone;
                            @endphp
                        @elseif($invoice->factory_type == 'cngpump')
                            @php
                            $items = $invoice->cngpump;
                            @endphp
                        @elseif($invoice->factory_type == 'weight')
                            @php
                            $items = $invoice->weight;
                            @endphp
                        @endif

                        @php
                           $m3 = 0;
                           $total = 0;
                           @endphp                    @foreach ($items as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item->date ? (\Carbon\Carbon::parse($item->date)->format('d-m-Y')) : 'N/A'  }}</td>
                            <td>{{ $item->bill_no }}</td>
                            <td>{{ $item->vehicle_reg_number }}</td>

                        @if ($invoice->factory_type == 'dispansar')
                           @php
                           $m3 += $item->total_reading;
                           @endphp
                            <td>{{ $item->total_reading }}</td>
                        @elseif($invoice->factory_type == 'weightone')
                            @php
                           $m3 += $item->fm3;
                           @endphp
                            <td>{{ $item->fm3 }}</td>
                        @elseif($invoice->factory_type == 'cngpump')
                            @php
                           $m3 += $item->fm3;
                           @endphp
                            <td>{{ $item->fm3 }}</td>
                        @elseif($invoice->factory_type == 'weight')
                            @php
                           $m3 += $item->receive_m3;
                           @endphp
                            <td>{{ $item->receive_m3 }}</td>
                        @endif

                            <td>{{ $item->rate }}</td>
                            
                        @if ($invoice->factory_type == 'dispansar')
                           @php
                           $total += $item->bill_amount;
                           @endphp
                            <td>{{ $item->bill_amount }}</td>
                        @elseif($invoice->factory_type == 'weightone')
                            @php
                           $total += $item->ftk;
                           @endphp
                            <td>{{ $item->ftk }}</td>
                        @elseif($invoice->factory_type == 'cngpump')
                            @php
                           $total += $item->ftk;
                           @endphp
                            <td>{{ $item->ftk }}</td>
                        @elseif($invoice->factory_type == 'weight')
                            @php
                           $total += $item->ftk;
                           @endphp
                            <td>{{ $item->ftk }}</td>
                        @endif

                            <td>
                        @if ($invoice->factory_type == 'dispansar')
                            <a href="{{ route('backend.factory.dispansar.edit', $item->id) }}" target="_blank" class="btn btn-info btn-sm">
                                <i class="fas fa-eye"></i> View
                            </a>
                            <a href="{{ route('backend.factory.dispansar.edit', $item->id) }}" target="_blank" class="btn btn-info btn-sm">
                                <i class="fas fa-pencil-alt"></i> Edit
                            </a>
                        @elseif($invoice->factory_type == 'weightone')
                            <a href="{{ route('backend.factory.weightone.show', $item->id) }}" target="_blank" class="btn btn-info btn-sm">
                                <i class="fas fa-eye"></i> View
                            </a>
                            <a href="{{ route('backend.factory.weightone.edit', $item->id) }}" target="_blank" class="btn btn-info btn-sm">
                                <i class="fas fa-pencil-alt"></i> Edit
                            </a>
                        @elseif($invoice->factory_type == 'cngpump')
                            <a href="{{ route('backend.factory.cngpump.show', $item->id) }}" target="_blank" class="btn btn-info btn-sm">
                                <i class="fas fa-eye"></i> View
                            </a>
                            <a href="{{ route('backend.factory.cngpump.edit', $item->id) }}" target="_blank" class="btn btn-info btn-sm">
                                <i class="fas fa-pencil-alt"></i> Edit
                            </a>
                        @elseif($invoice->factory_type == 'weight')
                            <a href="{{ route('backend.factory.weight.show', $item->id) }}" target="_blank" class="btn btn-info btn-sm">
                                <i class="fas fa-eye"></i> View
                            </a>
                            <a href="{{ route('backend.factory.weight.edit', $item->id) }}" target="_blank" class="btn btn-info btn-sm">
                                <i class="fas fa-pencil-alt"></i> Edit
                            </a>
                        @endif
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="4" class="text-right"><strong>Total:</strong></td>
                        <td>{{ $m3 }}</td>
                        <td></td>
                        <td>{{ $total }}</td>
                    </tr>
                </tbody>
                </table>
            
        </x-boilerplate::card>
    </div>
</div>
@endsection

