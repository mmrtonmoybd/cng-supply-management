@extends('boilerplate::layout.index', [
    'title' => 'Asset',
    'subtitle' => 'Edit Asset',
])

@section('content')
<x-boilerplate::form :route="['backend.asset.asset.update', $asset->id]" method="put">
    <div class="row">
        <div class="col-12 pb-3">
            <a href="{{ route('backend.asset.asset.index') }}" class="btn btn-default" data-toggle="tooltip" title="Asset lists">
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
        <div class="col-md-4">
            <x-boilerplate::input name='name' label='Asset Name' required :value="old('name', $asset->name)" placeholder='Asset Name'/>
        </div>
        <div class="col-md-4">
            @php
                // Use typeOptions from controller if available, else fallback
                $typeOptions = isset($typeOptions) ? $typeOptions : \App\Models\Asset::distinct()->pluck('type')->filter()->unique()->values()->toArray();
                $currentType = old('type', $asset->type);
            @endphp
            <label for="type">Type</label>
            <select name="type" id="type" class="form-control select2">
                <option value="">Select Type</option>
                @foreach ($typeOptions as $type)
                    <option value="{{ $type }}" @if ($currentType == $type) selected @endif>{{ $type }}</option>
                @endforeach
                @if($currentType && !in_array($currentType, $typeOptions))
                    <option value="{{ $currentType }}" selected>{{ $currentType }}</option>
                @endif
            </select>
            <input type="text" id="type_text" name="type_text" class="form-control mt-2" style="display:none;" placeholder="Enter new type" value="{{ $currentType && !in_array($currentType, $typeOptions) ? $currentType : '' }}">
        </div>
        <div class="col-md-4">
            @php
                $vehicleOptions = \App\Models\Vehicle::orderBy('vehicle_number', 'ASC')->pluck('vehicle_number', 'id')->toArray();
            @endphp
            <label for="vehicle_id">Vehicle (optional)</label>
            <select name="vehicle_id" class="form-control">
                <option value="">Select Vehicle</option>
                @foreach ($vehicleOptions as $key => $value)
                    <option value="{{ $key }}" @if (old('vehicle_id', $asset->vehicle_id) == $key) selected @endif>{{ $value }}</option>
                @endforeach
            </select>
        </div>
    </div>
</x-boilerplate::card>
        </div>
    </div>
</x-boilerplate::form>
@endsection

@push('js')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('#type').select2({
            tags: true,
            placeholder: 'Select Type',
            allowClear: true,
            width: '100%'
        });
        function toggleTypeInput() {
            var select = $('#type');
            var input = $('#type_text');
            var selected = select.val();
            var options = select.find('option').map(function(){return $(this).val();}).get();
            if(selected && !options.includes(selected)) {
                input.val(selected);
                input.show();
            } else if(selected === '' || selected === null) {
                input.hide();
                input.val('');
            } else {
                input.hide();
                input.val('');
            }
        }
        $('#type').on('change', function() {
            var selected = $(this).val();
            var options = $(this).find('option').map(function(){return $(this).val();}).get();
            if(selected && !options.includes(selected)) {
                $('#type_text').val(selected).show();
            } else if(selected === '' || selected === null) {
                $('#type_text').hide().val('');
            } else {
                $('#type_text').hide().val('');
            }
        });
        toggleTypeInput();
    });
</script>
@endpush
