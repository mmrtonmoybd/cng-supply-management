@push('js')
<script>
    $(document).on('change', '.highlight-select', function () {
        const select = $(this);
        const moduleId = select.data('id');
        const color = select.val();
        const moduleName = select.data('module') || 'loadEntry'; // Default module

        $.ajax({
            url: '{{ route('backend.highlight.save') }}',
            type: 'POST',
            data: {
                module_id: moduleId,
                module_name: moduleName,
                color: color,
                _token: '{{ csrf_token() }}',
            },
            success: function (res) {
                const row = select.closest('tr');

                // Remove old highlight-* classes
                row.removeClass(function (index, className) {
                    return (className.match(/(^|\s)highlight-\S+/g) || []).join(' ');
                });

                if (color !== 'none') {
                    row.addClass('highlight-' + color);
                }

                // ✅ Show success growl
                growl("Highlight color updated successfully.", "success");
            },
            error: function () {
                // ❌ Show error growl
                growl("Error saving highlight color.", "danger");
            }
        });
    });
</script>
@endpush
