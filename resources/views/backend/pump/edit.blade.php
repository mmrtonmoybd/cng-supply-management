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
                <button type="submit" class="btn btn-danger">
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
                        <x-boilerplate::input name='balance' label='Balance' type='number' step='0.01' required :value="old('balance', $pump->balance ?? '')" placeholder='Balance'/>
                    </div>
                    <div class="col-6">
                        <x-boilerplate::input name='premarks' label='Remarks' :value="old('premarks', $pump->remarks ?? '')" placeholder='Remarks'/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <h5>Load Entry</h5>
                        <button type="button" class="btn btn-secondary btn-sm" id="toggle-button" onclick="toggleLoadEntry()">Unhide</button>
                    </div>
                </div>
                <div id="load-entry-section" style="display: none;">
                    @if ($pump->loada)
                        <div class="row">
                            <div class="col-6">
                                <x-boilerplate::input name='date' label='Load Date' type='date' required :value="old('date', $pump->loada->date ?? '')" placeholder='Load Date'/>
                            </div>
                            <div class="col-6">
                                <x-boilerplate::input name='vehicle_reg_number' label='Vehicle Reg Number' required :value="old('vehicle_reg_number', $pump->loada->vehicle_reg_number ?? '')" placeholder='Vehicle Reg Number'/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <x-boilerplate::input name='pump_name' label='Pump Name' required :value="old('pump_name', $pump->loada->pump_name ?? '')" placeholder='Pump Name'/>
                            </div>
                            <div class="col-6">
                                <x-boilerplate::input name='cng_purchase_m3' label='CNG Purchase (M3)' type='number' step='0.01' required :value="old('cng_purchase_m3', $pump->loada->cng_purchase_m3 ?? '')" placeholder='CNG Purchase (M3)'/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <x-boilerplate::input name='rate' label='Rate' type='number' step='0.01' required :value="old('rate', $pump->loada->rate ?? '')" placeholder='Rate'/>
                            </div>
                            <div class="col-6">
                                <x-boilerplate::input name='purchase_taka' label='Purchase Taka' type='number' step='0.01' required :value="old('purchase_taka', $pump->loada->purchase_taka ?? '')" placeholder='Purchase Taka'/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <x-boilerplate::input name='fuel_cost' label='Fuel Cost' type='number' step='0.01' :value="old('fuel_cost', $pump->loada->fuel_cost ?? '')" placeholder='Fuel Cost'/>
                            </div>
                            <div class="col-6">
                                <x-boilerplate::input name='fuel_pump' label='Fuel Pump' :value="old('fuel_pump', $pump->loada->fuel_pump ?? '')" placeholder='Fuel Pump'/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <x-boilerplate::input name='factory_name' label='Factory Name' :value="old('factory_name', $pump->loada->factory_name ?? '')" placeholder='Factory Name'/>
                            </div>
                            <div class="col-6">
                                <x-boilerplate::select2 name="status" label="Status" minimum-results-for-search="1" required>
                                    <option value="1" @if (old('status', $pump->loada->status) == '1') selected="selected" @endif>Use</option>
                                    <option value="0" @if (old('status', $pump->loada->status) == '0') selected="selected" @endif>Not use</option>
                                </x-boilerplate::select2>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <x-boilerplate::input name='remark' label='Remark' :value="old('remark', $pump->loada->remark ?? '')" placeholder='Remark'/>
                            </div>
                        </div>
                    @else
                        <p class="text-danger">No associated Load Entry found.</p>
                    @endif
                </div>

                <script>
                    function toggleLoadEntry() {
                        const section = document.getElementById('load-entry-section');
                        const button = document.getElementById('toggle-button');
                        if (section.style.display === 'none') {
                            section.style.display = 'block';
                            button.textContent = 'Hide';
                        } else {
                            section.style.display = 'none';
                            button.textContent = 'Unhide';
                        }
                    }
                </script>
            </x-boilerplate::card>
        </div>
    </div>
</x-boilerplate::form>
@endsection