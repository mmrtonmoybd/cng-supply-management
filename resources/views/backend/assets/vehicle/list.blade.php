@extends('boilerplate::layout.index', [
    'title' => 'Vehicle',
    'subtitle' => 'Vehicle lists',
    'breadcrumb' => [
        'Vehicle' => 'backend.vehicle.vehicle.index',
    ]
])

@push('css')
<style>
.desc-wrapper {
  max-height: 30px;
  overflow: hidden;
  position: relative;
  cursor: pointer;
  transition: max-height 0.3s ease;
}

.desc-wrapper::after {
  content: '';
  position: absolute;
  bottom: 0;
  left: 0;
  right: 0;
  height: 20px;
  background: linear-gradient(to bottom, rgba(255,255,255,0), #fff);
}

.desc-wrapper.expanded {
  max-height: 1000px;
}

.desc-wrapper.expanded::after {
  display: none;
}

.activity-desc {
  white-space: normal !important;
}

</style>

@endpush

@section('content')
    <div class="row">
        <div class="col-12 mbl">
            <span class="float-right pb-3">
                <a href="{{route('backend.vehicle.vehicle.create')}}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Vehicle
                </a>
            </span>
            <span class="float-right pb-3 mr-2">
                <a href="{{ route('backend.vehicle.vehicledocument.index') }}" class="btn btn-warning">
                    <i class="fas fa-folder-open"></i> Vehicle document
                </a>
                <a href="{{ route('backend.vehicle.vehiclemaintenance.index') }}" class="btn btn-success">
                    <i class="fas fa-tools"></i> Maintenance
                </a>
            </span>
            
        </div>
    </div>
    <x-boilerplate::card>
    <x-boilerplate::datatable name="vehicle" />
    </x-boilerplate::card>
@endsection

@push('js')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Delegate click to dynamically created DataTable rows
    document.addEventListener('click', function (e) {
        if (e.target.closest('.desc-wrapper')) {
            e.target.closest('.desc-wrapper').classList.toggle('expanded');
        }
    });
});
</script>

@endpush