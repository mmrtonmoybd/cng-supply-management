@push('css')
<style>
    /* Duplicate rows */
    tr.alert-danger {
        background-color: #dc3545 !important;  /* Deep red */
        color: #fff !important;
        font-weight: bold;
        transition: background-color 0.3s ease;
    }

    tr.alert-danger:hover {
        background-color: #bd2130 !important;
    }

    /* Highlighted rows */
    .highlight-red {
        background-color: #ffcdd2 !important;
    }

    .highlight-yellow {
        background-color: #fff9c4 !important;
    }

    .highlight-green {
        background-color: #c8e6c9 !important;
    }

    .highlight-blue {
        background-color: #bbdefb !important;
    }

    /* Optional: hover for highlights */
    tr.highlight-red:hover {
        background-color: #f8a4a4 !important;
    }

    tr.highlight-yellow:hover {
        background-color: #ffe066 !important;
    }

    tr.highlight-green:hover {
        background-color: #a5d6a7 !important;
    }

    tr.highlight-blue:hover {
        background-color: #90caf9 !important;
    }
</style>
@endpush
