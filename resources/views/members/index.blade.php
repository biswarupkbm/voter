<!DOCTYPE html>
<html>
<head>
    <title>Members List</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body class="bg-light p-4">

<div class="container mt-4">
    <h2 class="mb-4">Members List</h2>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped align-middle">
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
                <th width="150">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($members as $index => $member)
                <tr data-id="{{ $member->id }}">
                    <td>{{ $index + 1 }}</td>
                    <td><input type="text" class="form-control-plaintext" value="{{ $member->name }}" readonly></td>
                    <td><input type="text" class="form-control-plaintext" value="{{ $member->father_name }}" readonly></td>
                    <td><input type="text" class="form-control-plaintext" value="{{ $member->voter_id }}" readonly></td>
                    <td><input type="text" class="form-control-plaintext" value="{{ $member->gender }}" readonly></td>
                    <td><input type="text" class="form-control-plaintext" value="{{ $member->village }}" readonly></td>
                    <td><input type="text" class="form-control-plaintext" value="{{ $member->post }}" readonly></td>
                    <td><input type="text" class="form-control-plaintext" value="{{ $member->panchayath }}" readonly></td>
                    <td><input type="text" class="form-control-plaintext" value="{{ $member->mandal }}" readonly></td>
                    <td><input type="text" class="form-control-plaintext" value="{{ $member->state }}" readonly></td>
                    <td>
                        @if($member->voter_card_url)
                            <a href="{{ $member->voter_card_url }}" class="btn btn-info btn-sm" target="_blank">
                                <i class="fa fa-eye"></i>
                            </a>
                        @else
                            <span class="text-muted">No File</span>
                        @endif
                    </td>
                    <td>
                        <button class="btn btn-warning btn-sm edit-btn"><i class="fa fa-edit"></i></button>
                        <button class="btn btn-success btn-sm save-btn d-none"><i class="fa fa-check"></i></button>
                        <form action="{{ route('members.destroy', $member->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Delete this member?')">
                                <i class="fa fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Handle Edit
    document.querySelectorAll('.edit-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
            let row = btn.closest('tr');
            row.querySelectorAll('input').forEach(input => {
                input.removeAttribute('readonly');
                input.classList.add('form-control');
            });
            btn.classList.add('d-none');
            row.querySelector('.save-btn').classList.remove('d-none');
        });
    });

    // Handle Save
    document.querySelectorAll('.save-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
            let row = btn.closest('tr');
            let id = row.dataset.id;
            let inputs = row.querySelectorAll('input');
            let data = {};
            let fields = ['name','father_name','voter_id','gender','village','post','panchayath','mandal','state'];

            inputs.forEach((input, index) => {
                data[fields[index]] = input.value;
            });

            fetch(`/members/${id}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(data)
            })
            .then(res => res.json())
            .then(response => {
                alert(response.message || 'Updated successfully!');
                inputs.forEach(input => {
                    input.setAttribute('readonly', true);
                    input.classList.remove('form-control');
                });
                btn.classList.add('d-none');
                row.querySelector('.edit-btn').classList.remove('d-none');
            })
            .catch(err => console.error(err));
        });
    });
});
</script>

</body>
</html>
