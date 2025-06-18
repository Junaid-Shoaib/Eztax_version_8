

<!-- Bootstrap CSS (if not already included) -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Toastr -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<!-- DataTables with Bootstrap 5 integration CSS -->
<link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<style>
    @media (max-width:500px)
    {
        div.dataTables_wrapper div.dt-row {
            overflow-x: scroll;
        }
    }
    .custom-tab-nav .nav-link {
        border: none;
        background-color: #f8fafd; /* light background */
        color: #6c757d; /* text-muted */
        border-radius: 0.375rem;
        margin-right: 4px;
        padding: 0.5rem 1rem;
        transition: 0.3s;
        display: flex;
        align-items: center;
        gap: 6px;
        min-width: 160px; /* Or any width you prefer */
        justify-content: center;
        text-align: center;
    }

    .custom-tab-nav .nav-link.active {
        background-color: #fff;
        color: #000;
        font-weight: 600;
        box-shadow: 0 2px 6px rgba(0,0,0,0.05);
    }

    .custom-tab-nav .nav-link i {
        font-size: 1rem;
    }

    .nav-tabs.custom-tab-nav {
        border-bottom: none;
        background-color: #f1f5f9;
        padding: 0.5rem;
        border-radius: 0.5rem;
    }
    
</style>
@stack('css')