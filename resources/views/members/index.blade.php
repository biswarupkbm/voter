<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Members List</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .action-col {
            width: 150px;
            white-space: nowrap;
            text-align: center;
        }
        .action-col .btn {
            margin-right: 5px;
        }
        td input[readonly] {
            border: none;
            background: transparent;
            padding-left: 0;
        }
        td img, .fa-eye {
            cursor: pointer;
        }
    </style>
</head>
<body class="bg-light">

<div class="container mt-4">
    <h2 class="mb-3">Members List</h2>

    <table class="table table-bordered align-middle">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Father Name</th>
                <th>Voter ID</th>
                <th>Gender</th>
                <th>Village</th>
                <th>Post</th>
                <th>Panchayath</th>
                <th>Mandal</th>
                <th>State</th>
                <th>Voter Card</th>
                <th class="action-col">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($members as $index => $member)
            <tr data-id="{{ $member->id }}">
                <td>{{ $index+1 }}</td>
                <td><input type="text" class="form-control field" name="name" value="{{ $member->name }}" readonly></td>
                <td><input type="text" class="form-control field" name="father_name" value="{{ $member->father_name }}" readonly></td>
                <td><input type="text" class="form-control field" name="voter_id" value="{{ $member->voter_id }}" readonly></td>
                <td><input type="text" class="form-control field" name="gender" value="{{ $member->gender }}" readonly></td>
                <td><input type="text" class="form-control field" name="village" value="{{ $member->village }}" readonly></td>
                <td><input type="text" class="form-control field" name="post" value="{{ $member->post }}" readonly></td>
                <td><input type="text" class="form-control field" name="panchayath" value="{{ $member->panchayath }}" readonly></td>
                <td><input type="text" class="form-control field" name="mandal" value="{{ $member->mandal }}" readonly></td>
                <td><input type="text" class="form-control field" name="state" value="{{ $member->state }}" readonly></td>
                <td class="text-center">
                    @if($member->voter_card)
                        <i class="fa fa-eye text-info fs-5" onclick="viewVoterCard('{{ asset('storage/' . $member->voter_card) }}')"></i>
                    @else
                        <span class="text-muted">No Image</span>
                    @endif
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

<script>
$(document).ready(function () {
    let originalValues = {};

    // Edit
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

    // Save
    $(document).on('click', '.save-btn', function () {
        let row = $(this).closest('tr');
        let id = row.data('id');
        let formData = {};
        let hasChanges = false;

        row.find('.field').each(function () {
            let name = $(this).attr('name');
            let value = $(this).val();
            formData[name] = value;
            if (value !== originalValues[id][name]) {
                hasChanges = true;
            }
        });

        if (!hasChanges) {
            row.find('.field').prop('readonly', true);
            row.find('.save-btn').addClass('d-none');
            row.find('.edit-btn').removeClass('d-none');
            return;
        }

        $.ajax({
            url: '/members/' + id,
            type: 'PUT',
            data: formData,
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            success: function (response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Updated!',
                        text: 'Member details updated successfully.',
                        timer: 1500,
                        showConfirmButton: false
                    });
                }
                row.find('.field').prop('readonly', true);
                row.find('.save-btn').addClass('d-none');
                row.find('.edit-btn').removeClass('d-none');
                originalValues[id] = { ...formData };
            }
        });
    });

    // Delete
    $(document).on('click', '.delete-btn', function () {
        let row = $(this).closest('tr');
        let id = row.data('id');

        Swal.fire({
            title: 'Are you sure?',
            text: "This member will be deleted.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/members/' + id,
                    type: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    success: function (response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted!',
                                text: 'Member removed successfully.',
                                timer: 1500,
                                showConfirmButton: false
                            });
                            row.remove();
                        }
                    }
                });
            }
        });
    });
});

// Show voter card image in SweetAlert
function viewVoterCard(imageUrl) {
    Swal.fire({
        title: 'Voter Card',
        imageUrl: imageUrl,
        imageAlt: 'Voter Card',
        confirmButtonText: 'Close'
    });
}
</script>

</body>
</html>
