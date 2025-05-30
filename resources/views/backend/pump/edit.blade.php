@extends('boilerplate::layout.index', [
    'title' => 'Pump',
    'subtitle' => 'Edit Pump',
])

@section('content')
<x-boilerplate::form :route="['backend.pump.update', $pump->id]" method="put">
    <div class="row">
        <div class="col-12 pb-3">
            <a href="{{ route('backend.pump.index') }}" class="btn btn-default" data-toggle="tooltip" title="Pump lists">
                <span class="far fa-arrow-alt-circle-left text-muted"></span>
            </a>
            <span class="btn-group float-right">
                <button type="submit" class="btn btn-primary">
                    Update
                </button>
         </span>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <x-boilerplate::card>
                <div class="row">
                    <div class="col-12">
                        <h5>Pump</h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <x-boilerplate::input name='payment_date' label='Payment Date' type='date' required :value="old('payment_date', $pump->payment_date ?? '')" placeholder='Payment Date'/>
                    </div>
                    <div class="col-6">
                        <x-boilerplate::input name='payment' label='Payment' type='number' step='0.01' required :value="old('payment', $pump->payment ?? '')" placeholder='Payment'/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <x-boilerplate::input name='premarks' label='Remarks' :value="old('premarks', $pump->remarks ?? '')" placeholder='Remarks'/>
                    </div>
                </div>
                
            </x-boilerplate::card>
        </div>
    </div>
</x-boilerplate::form>
@endsection