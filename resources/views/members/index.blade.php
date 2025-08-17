<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <!-- Title -->
    <title>voters</title>
    <!-- Favicon Icon -->
    <link rel="shortcut icon" href="assets/images/voter/logo/logo.png" type="image/x-icon">
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
        .highlight { background-color: yellow; font-weight: bold; }
    </style>
</head>
<body class="bg-light">

<div class="container mt-4">
    <h2 class="mb-3">Members List</h2>

    <!-- Session Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Search input -->
    <div class="mb-3 d-flex justify-content-between">
        <input type="text" id="memberSearch" class="form-control me-2" placeholder="Search members...">
        <button id="downloadBtn" class="btn btn-primary">Download</button>
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
                        @if($member->voter_card && $member->voter_card !== 'N/A')
                            <i class="fa fa-eye text-info fs-5 view-card" style="cursor:pointer" data-src="{{ asset($member->voter_card) }}"></i>
                            <br>
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
$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

$(function () {
    // Inline Edit
    $(document).on('click', '.edit-btn', function () {
        let row = $(this).closest('tr');
        row.find('.field').prop('readonly', false);
        $(this).addClass('d-none');
        row.find('.save-btn').removeClass('d-none');
    });

    $(document).on('click', '.save-btn', function () {
        let row = $(this).closest('tr');
        let id = row.data('id');
        let payload = {};
        row.find('.field').each(function () { payload[$(this).attr('name')] = $(this).val(); });

        $.ajax({
            url: '/members/' + id,
            type: 'PUT',
            data: payload,
            success: function (res) {
                Swal.fire({ icon:'success', title:'Saved', timer:1200, showConfirmButton:false });
                row.find('.field').prop('readonly', true);
                row.find('.save-btn').addClass('d-none');
                row.find('.edit-btn').removeClass('d-none');
            },
            error: function (xhr) { Swal.fire('Error', 'Save failed', 'error'); }
        });
    });

    // Delete
    $(document).on('click', '.delete-btn', function () {
        let row = $(this).closest('tr');
        let id = row.data('id');
        Swal.fire({
            title: 'Confirm delete?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete'
        }).then(result => {
            if (!result.isConfirmed) return;
            $.ajax({
                url: '/members/' + id,
                type: 'DELETE',
                success: function () {
                    row.remove();
                    $('#membersTable tbody tr').each((i,tr) => $(tr).find('.row-index').text(i+1));
                    Swal.fire({ icon:'success', title:'Deleted', timer:1200, showConfirmButton:false });
                }
            });
        });
    });

    // View card
    $(document).on('click', '.view-card', function () {
        Swal.fire({ title:'Voter Card', imageUrl: $(this).data('src'), confirmButtonText:'Close' });
    });

    // Upload card
    $(document).on('click', '.upload-card-btn', function () {
        $('.upload-input[data-id="'+$(this).data('id')+'"]').trigger('click');
    });

    $(document).on('change', '.upload-input', function () {
        const id = $(this).data('id');
        const fd = new FormData();
        if(this.files.length === 0) return;
        fd.append('voter_card', this.files[0]);

        Swal.fire({ title:'Uploading...', didOpen:()=> Swal.showLoading() });
        $.ajax({
            url: '/members/' + id + '/upload-card',
            type: 'POST',
            processData: false,
            contentType: false,
            data: fd,
            success: function(res) {
                Swal.close();
                Swal.fire({ icon:'success', title:'Uploaded', timer:1200, showConfirmButton:false });
                const row = $('tr[data-id="'+id+'"]');
                const cell = row.find('.voter-card-cell');
                const html = '<i class="fa fa-eye text-info fs-5 view-card" data-src="'+res.path+'"></i><br>' +
                             '<div><button class="btn btn-sm btn-outline-secondary mt-1 upload-card-btn" data-id="'+id+'">Upload</button>' +
                             '<input type="file" class="upload-input form-control form-control-sm" data-id="'+id+'" accept="image/*"></div>';
                cell.html(html);
            },
            error: function(){ Swal.close(); Swal.fire('Error', 'Upload failed', 'error'); }
        });
    });

    // Search + highlight
    $('#memberSearch').on('keyup', function () {
        const query = $(this).val().toLowerCase();
        let anyVisible = false;

        $('#membersTable tbody tr').each(function () {
            let row = $(this);
            let match = false;

            row.find('.field').each(function () {
                let text = $(this).val();
                $(this).next('.highlight-span').remove();

                if (query && text.toLowerCase().includes(query)) {
                    match = true;
                    const regex = new RegExp('(' + query + ')', 'gi');
                    const highlighted = text.replace(regex, '<span class="highlight">$1</span>');
                    $(this).after('<span class="highlight-span">' + highlighted + '</span>');
                }
            });

            row.toggle(match);
            if (match) anyVisible = true;
        });

        if (!anyVisible && query) {
            $('#membersTable tbody tr').show();
            $('#membersTable tbody tr .highlight-span').remove();
        }

        let counter = 1;
        $('#membersTable tbody tr:visible').each(function () {
            $(this).find('.row-index').text(counter++);
        });
    });

    // ==================== DOWNLOAD POPUP ====================
    $('#downloadBtn').on('click', function(){
        Swal.fire({
            title: 'Select Download Options',
            html:
                '<label>File Type:</label>' +
                '<select id="swalFileType" class="swal2-select">' +
                    '<option value="excel">Excel</option>' +
                    '<option value="csv">CSV</option>' +
                    '<option value="pdf">PDF</option>' +
                '</select><br><br>' +
                '<label>Image Option:</label>' +
                '<select id="swalImageOption" class="swal2-select">' +
                    '<option value="with">With Image</option>' +
                    '<option value="without">Without Image</option>' +
                    '<option value="url">Image URL</option>' +
                '</select>',
            focusConfirm: false,
            showCancelButton: true,
            preConfirm: () => {
                const fileType = $('#swalFileType').val();
                let imageOption = $('#swalImageOption').val();
                if(fileType === 'csv') imageOption = 'without';
                return { fileType, imageOption };
            },
            didOpen: () => {
                $('#swalFileType').on('change', function(){
                    const type = $(this).val();
                    if(type === 'csv') {
                        $('#swalImageOption').val('without');
                        $('#swalImageOption option[value="with"]').prop('disabled', true);
                    } else {
                        $('#swalImageOption option[value="with"]').prop('disabled', false);
                    }
                }).trigger('change');
            }
        }).then((result)=>{
            if(result.isConfirmed){
                const options = result.value;
                // ✅ UPDATED DOWNLOAD URL
                window.location.href = `/members/download?fileType=${options.fileType}&imageOption=${options.imageOption}&searchQuery=${$('#memberSearch').val()}`;
            }
        });
    });

});
</script>
</body>
</html>
