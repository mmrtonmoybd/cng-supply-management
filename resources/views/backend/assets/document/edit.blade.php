@extends('boilerplate::layout.index', [
    'title' => __('Asset Document'),
    'subtitle' => __('Edit Asset Document'),
])

@section('content')
<x-boilerplate::form method="put" :route="['backend.asset.assetdocument.update', $assetdocument->id]" enctype="multipart/form-data">
    <div class="row">
        <div class="col-12 pb-3">
            <a href="{{ route('backend.asset.assetdocument.index') }}" class="btn btn-default" data-toggle="tooltip" title="Asset Document List">
                <span class="far fa-arrow-alt-circle-left text-muted"></span>
            </a>
            <span class="btn-group float-right">
                <button type="submit" class="btn btn-primary">
                    {{ __('Update') }}
                </button>
            </span>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
<x-boilerplate::card>
    <div class="row">
        <div class="col-md-4">
            @php
                $assetOptions = \App\Models\Asset::groupBy('type')->orderBy('name', 'ASC')->get()->mapWithKeys(function($asset) {
                    return [$asset->id => $asset->name . ($asset->type ? ' - ' . $asset->type : '')];
                })->toArray();
            @endphp
            <label for="asset_id">Asset</label>
            <select name="asset_id" class="form-control" required>
                <option value="">Select Asset</option>
                @foreach ($assetOptions as $key => $value)
                    <option value="{{ $key }}" @if (old('asset_id', $assetdocument->asset_id) == $key) selected @endif>{{ $value }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <x-boilerplate::input name="name" label="Document Name" required :value="old('name', $assetdocument->name)" placeholder="Document Name" />
        </div>
        <div class="col-md-4">
            <label for="document-dropzone">Document File <span class="text-danger">*</span></label>
            <div id="document-dropzone" class="dropzone dz-clickable" style="border: 2px dashed #007bff; padding: 30px; text-align: center; cursor: pointer;">
                <input type="file" name="path" id="file-input" style="display:none;" accept=".pdf,.jpg,.jpeg,.png" />
                <div class="dz-message">Drag & drop a file here or click to select</div>
            </div>
            <div id="document-preview" class="mt-3" style="display:none;"></div>
            @if($assetdocument->path)
                <div id="current-document" class="mt-2">
                    <strong>Current Document:</strong>
                    @php
                        $ext = strtolower(pathinfo($assetdocument->document_url, PATHINFO_EXTENSION));
                    @endphp
                    @if(in_array($ext, ['jpg','jpeg','png']))
                        <img src="{{ asset('/'.$assetdocument->document_url) }}" alt="Current Document" style="max-width:200px;" />
                    @elseif($ext === 'pdf')
                        <embed src="{{ asset($assetdocument->document_url) }}" type="application/pdf" width="100%" height="400px" />
                    @else
                        <a href="{{ asset($assetdocument->document_url) }}" target="_blank">Download</a>
                    @endif
                </div>
            @endif
        </div>
    </div>
</x-boilerplate::card>
        </div>
    </div>
</x-boilerplate::form>
@endsection

@push('js')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.css" />
<script>
const dropzone = document.getElementById('document-dropzone');
const fileInput = document.getElementById('file-input');
const preview = document.getElementById('document-preview');
// Click to open file dialog
 dropzone.addEventListener('click', function(e) {
    if (e.target === dropzone || e.target.classList.contains('dz-message')) {
        fileInput.click();
    }
});
// Drag & drop
 dropzone.addEventListener('dragover', function(e) {
    e.preventDefault();
    dropzone.classList.add('bg-light');
});
dropzone.addEventListener('dragleave', function(e) {
    e.preventDefault();
    dropzone.classList.remove('bg-light');
});
dropzone.addEventListener('drop', function(e) {
    e.preventDefault();
    dropzone.classList.remove('bg-light');
    if (e.dataTransfer.files.length) {
        fileInput.files = e.dataTransfer.files;
        showPreview(fileInput.files[0]);
    }
});
// File input change
fileInput.addEventListener('change', function() {
    if (fileInput.files.length) {
        showPreview(fileInput.files[0]);
    }
});
function showPreview(file) {
    let ext = file.name.split('.').pop().toLowerCase();
    let html = '';
    if(['jpg','jpeg','png'].includes(ext)) {
        const reader = new FileReader();
        reader.onload = function(e) {
            html = `<img src="${e.target.result}" alt="Preview" style="max-width:200px;" />`;
            preview.innerHTML = html;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(file);
    } else if(ext === 'pdf') {
        const reader = new FileReader();
        reader.onload = function(e) {
            html = `<embed src="${e.target.result}" type="application/pdf" width="100%" height="400px" />`;
            preview.innerHTML = html;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(file);
    } else {
        preview.innerHTML = '';
        preview.style.display = 'none';
    }
}
</script>
@endpush
