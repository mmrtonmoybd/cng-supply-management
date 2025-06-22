@extends('boilerplate::layout.index', [
    'title' => 'Activity',
    'subtitle' => 'Activity lists',
    'breadcrumb' => [
        'Activity' => 'backend.activity.index',
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
    <x-boilerplate::card>
    <x-boilerplate::datatable name="activitylog" />
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
