@extends('boilerplate::layout.index', [
    'title' => 'Diesel',
    'subtitle' => 'View Diesel Details',
])

@section('content')
    <div class="row">
        <div class="col-12 pb-3">
            <a href="{{ route('backend.diesel.index') }}" class="btn btn-default" data-toggle="tooltip" title="Diesel lists">
                <span class="far fa-arrow-alt-circle-left text-muted"></span>
            </a>
            <div class="btn-group float-right">
                <a href="{{ route('backend.diesel.edit', $diesel->id) }}" class="btn btn-primary">
                    <i class="fas fa-edit"></i> Edit
                </a>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-12">
            <x-boilerplate::card>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Load Date</label>
                            <p class="form-control-static">{{ $diesel->d_date ? date('d-m-Y', strtotime($diesel->d_date)) : '-' }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Load Time</label>
                            <p class="form-control-static">{{ $diesel->d_time ? date('h:i A', strtotime($diesel->d_time)) : '-' }}</p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Slip No</label>
                            <p class="form-control-static">{{ $diesel->slip_no ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Pump Name</label>
                            <p class="form-control-static">{{ $diesel->pumpname->name ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Vehicle</label>
                            <p class="form-control-static">{{ $diesel->vehicle_reg_number }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Diesel Purchase (Litre)</label>
                            <p class="form-control-static">{{ number_format($diesel->diesel_purchase_litre, 2) }}</p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Taka</label>
                            <p class="form-control-static">{{ number_format($diesel->taka, 2) }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Usage Date</label>
                            <p class="form-control-static">{{ $diesel->date ? date('d-m-Y', strtotime($diesel->date)) : '-' }}</p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Usage Time</label>
                            <p class="form-control-static">{{ $diesel->time ? date('h:i A', strtotime($diesel->time)) : '-' }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Distance (km)</label>
                            <p class="form-control-static">{{ $diesel->distance ? number_format($diesel->distance, 2) : '-' }}</p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Use Litre</label>
                            <p class="form-control-static">{{ $diesel->use_litre ? number_format($diesel->use_litre, 2) : '-' }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Use Balance</label>
                            <p class="form-control-static">{{ $diesel->use_balance ? number_format($diesel->use_balance, 2) : '-' }}</p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Due/Advance Litre</label>
                            <p class="form-control-static">{{ $diesel->use_litre && $diesel->diesel_purchase_litre ? number_format($diesel->diesel_purchase_litre - $diesel->use_litre, 2) : '-' }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Due/Advance</label>
                            <p class="form-control-static">{{ $diesel->use_balance && $diesel->taka ? number_format($diesel->taka - $diesel->use_balance, 2) : '-' }}</p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label>Remark</label>
                            <p class="form-control-static">{{ $diesel->remark ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </x-boilerplate::card>
        </div>
    </div>
@endsection
