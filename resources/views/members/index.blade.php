<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Members List</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .action-col { width: 200px; text-align: center; white-space: nowrap; }
        .action-col .btn { margin-right: 5px; }
        td input[readonly] { border: none; background: transparent; padding-left: 0; }
        .table-responsive { overflow: auto; }
        .upload-input { display: none; }
    </style>
</head>
<body class="bg-light">

<div class="container mt-4">
    <h2 class="mb-3">Members List</h2>

    {{-- Flash messages --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Validation errors --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="mb-3 d-flex gap-2">
        <a href="{{ route('members.create') }}" class="btn btn-primary">Add New Member</a>

        <form id="importForm" action="{{ route('members.import') }}" method="POST" enctype="multipart/form-data" class="d-flex align-items-center gap-2">
            @csrf
            <!-- accept only Excel per your requirement -->
            <input type="file" name="file" id="importFile" accept=".xls, .xlsx" class="form-control form-control-sm" style="max-width:300px;">
            <button type="submit" class="btn btn-outline-secondary btn-sm">Import Excel (.xls / .xlsx)</button>
        </form>

        <button id="saveAllBtn" class="btn btn-success ms-auto">Save All Changes (Bulk)</button>
    </div>

    <div class="table-responsive">
    <table class="table table-bordered align-middle" id="membersTable">
        <thead class="table-dark">
            <tr>
                <th>#</th><th>Name</th><th>Father Name</th><th>Voter ID</th>
                <th>Gender</th><th>Village</th><th>Post</th><th>Panchayath</th>
                <th>Mandal</th><th>State</th><th>Voter Card</th><th class="action-col">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($members as $index => $member)
            <tr data-id="{{ $member->id }}">
                <td class="row-index">{{ $index+1 }}</td>
                <td><input type="text" class="form-control field" name="name" value="{{ $member->name }}" readonly></td>
                <td><input type="text" class="form-control field" name="father_name" value="{{ $member->father_name }}" readonly></td>
                <td><input type="text" class="form-control field" name="voter_id" value="{{ $member->voter_id }}" readonly></td>
                <td><input type="text" class="form-control field" name="gender" value="{{ $member->gender }}" readonly></td>
                <td><input type="text" class="form-control field" name="village" value="{{ $member->village }}" readonly></td>
                <td><input type="text" class="form-control field" name="post" value="{{ $member->post }}" readonly></td>
                <td><input type="text" class="form-control field" name="panchayath" value="{{ $member->panchayath }}" readonly></td>
                <td><input type="text" class="form-control field" name="mandal" value="{{ $member->mandal }}" readonly></td>
                <td><input type="text" class="form-control field" name="state" value="{{ $member->state }}" readonly></td>
                <td class="text-center voter-card-cell">
                    {{-- show icon only when voter_card is set and not the default 'N/A' --}}
                    @if($member->voter_card && $member->voter_card !== 'N/A')
                        <i class="fa fa-eye text-info fs-5 view-card" style="cursor:pointer" data-src="{{ asset($member->voter_card) }}" title="View"></i>
                        <br>
                        <!-- <img src="{{ asset($member->voter_card) }}" alt="card" style="max-width:60px; margin-top:6px; cursor:pointer" class="img-thumbnail view-card" data-src="{{ asset($member->voter_card) }}"> -->
                    @else
                        <span class="text-muted">No Image</span>
                    @endif
                    <div>
                        <button class="btn btn-sm btn-outline-secondary mt-1 upload-card-btn" data-id="{{ $member->id }}">Upload</button>
                        <input type="file" class="upload-input form-control form-control-sm" data-id="{{ $member->id }}" accept="image/*">
                    </div>
                </td>
                <td class="action-col">
                    <button class="btn btn-success btn-sm save-btn d-none"><i class="fa fa-check"></i></button>
                    <button class="btn btn-primary btn-sm edit-btn"><i class="fa fa-edit"></i></button>
                    <button class="btn btn-danger btn-sm delete-btn"><i class="fa fa-trash"></i></button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    </div>
</div>

<script>
$.ajaxSetup({
    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
});

$(function () {
    let originalValues = {};

    // Edit row
    $(document).on('click', '.edit-btn', function () {
        let row = $(this).closest('tr');
        row.find('.field').prop('readonly', false);
        $(this).addClass('d-none');
        row.find('.save-btn').removeClass('d-none');

        let id = row.data('id');
        originalValues[id] = {};
        row.find('.field').each(function () {
            originalValues[id][$(this).attr('name')] = $(this).val();
        });
    });

    // Save single row (AJAX PUT)
    $(document).on('click', '.save-btn', function () {
        let row = $(this).closest('tr');
        let id = row.data('id');
        let payload = {};
        row.find('.field').each(function () {
            payload[$(this).attr('name')] = $(this).val();
        });

        $.ajax({
            url: '/members/' + id,
            type: 'PUT',
            data: payload,
            success: function (res) {
                if (res.success) {
                    Swal.fire({ icon:'success', title:'Saved', text: res.message ?? 'Saved', timer: 1200, showConfirmButton:false });
                }
                row.find('.field').prop('readonly', true);
                row.find('.save-btn').addClass('d-none');
                row.find('.edit-btn').removeClass('d-none');
                originalValues[id] = {...payload};
            },
            error: function (xhr) {
                let msg = 'Save failed';
                if (xhr.responseJSON && xhr.responseJSON.message) msg = xhr.responseJSON.message;
                Swal.fire('Error', msg, 'error');
            }
        });
    });

    // Delete row
    $(document).on('click', '.delete-btn', function () {
        let row = $(this).closest('tr');
        let id = row.data('id');

        Swal.fire({
            title: 'Confirm delete?',
            text: "This will permanently remove the member.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/members/' + id,
                    type: 'DELETE',
                    success: function (res) {
                        if (res.success) {
                            row.remove();
                            Swal.fire({ icon:'success', title:'Deleted', timer:1200, showConfirmButton:false });
                            // reindex table row numbers
                            $('#membersTable tbody tr').each(function(i){
                                $(this).find('.row-index').text(i+1);
                            });
                        }
                    }
                });
            }
        });
    });

    // Save All (bulk-upsert)
    $('#saveAllBtn').on('click', function () {
        let rows = [];
        $('#membersTable tbody tr').each(function () {
            let r = {};
            r.id = $(this).data('id');
            $(this).find('.field').each(function () {
                r[$(this).attr('name')] = $(this).val();
            });
            // include voter_card path if present (not changing via this bulk)
            // r.voter_card = ...;
            rows.push(r);
        });

        Swal.fire({
            title: 'Save all changes?',
            text: 'This will update existing records and insert new ones if voter_id is new.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes, save'
        }).then((result) => {
            if (!result.isConfirmed) return;
            $.ajax({
                url: '{{ route("members.bulkUpsert") }}',
                type: 'POST',
                data: { members: rows },
                success: function (res) {
                    if (res.success) {
                        Swal.fire({ icon:'success', title: 'Saved', text: res.message, timer:1500, showConfirmButton:false })
                            .then(()=> location.reload());
                    }
                },
                error: function (xhr) {
                    let msg = 'Bulk save failed';
                    if (xhr.responseJSON && xhr.responseJSON.message) msg = xhr.responseJSON.message;
                    Swal.fire('Error', msg, 'error');
                }
            });
        });
    });

    // Import form submit (allow server side processing)
    $('#importForm').on('submit', function (e) {
        // allow normal submit to show flash messages and redirect back
    });

    // View voter card (click icon or small image)
    $(document).on('click', '.view-card', function () {
        const src = $(this).data('src');
        Swal.fire({
            title: 'Voter Card',
            imageUrl: src,
            imageAlt: 'Voter Card',
            confirmButtonText: 'Close'
        });
    });

    // Upload card: show file input
    $(document).on('click', '.upload-card-btn', function () {
        const id = $(this).data('id');
        const input = $('.upload-input[data-id="'+id+'"]');
        input.trigger('click');
    });

    // When a file selected, upload via AJAX for that specific member
    $(document).on('change', '.upload-input', function () {
        const id = $(this).data('id');
        const fileInput = this;
        if (fileInput.files.length === 0) return;
        const fd = new FormData();
        fd.append('voter_card', fileInput.files[0]);

        Swal.fire({
            title: 'Uploading...',
            didOpen: () => Swal.showLoading()
        });

        $.ajax({
            url: '/members/' + id + '/upload-card',
            type: 'POST',
            processData: false,
            contentType: false,
            data: fd,
            success: function (res) {
                Swal.close();
                if (res.success) {
                    Swal.fire({ icon:'success', title:'Uploaded', timer:1200, showConfirmButton:false });
                    // update the cell image
                    const row = $('tr[data-id="'+id+'"]');
                    const cell = row.find('.voter-card-cell');
                    const imgHtml = '<i class="fa fa-eye text-info fs-5 view-card" data-src="'+res.path+'"></i><br><img src="'+res.path+'" alt="card" style="max-width:60px; margin-top:6px; cursor:pointer" class="img-thumbnail view-card" data-src="'+res.path+'">';
                    // keep upload controls
                    const uploadControls = '<div><button class="btn btn-sm btn-outline-secondary mt-1 upload-card-btn" data-id="'+id+'">Upload</button><input type="file" class="upload-input form-control form-control-sm" data-id="'+id+'" accept="image/*"></div>';
                    cell.html(imgHtml + uploadControls);
                } else {
                    Swal.fire('Error', res.message || 'Upload failed', 'error');
                }
            },
            error: function (xhr) {
                Swal.close();
                let msg = 'Upload failed';
                if (xhr.responseJSON && xhr.responseJSON.message) msg = xhr.responseJSON.message;
                Swal.fire('Error', msg, 'error');
            }
        });
    });

});
</script>
</body>
</html>
