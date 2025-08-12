<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Members List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4 bg-light">

<div class="container mt-4">
    <h2 class="mb-4">Members List</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped">
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
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($members as $index => $member)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $member->name }}</td>
                    <td>{{ $member->father_name }}</td>
                    <td>{{ $member->voter_id }}</td>
                    <td>{{ $member->gender }}</td>
                    <td>{{ $member->village }}</td>
                    <td>{{ $member->post }}</td>
                    <td>{{ $member->panchayath }}</td>
                    <td>{{ $member->mandal }}</td>
                    <td>{{ $member->state }}</td>
                    <td>
                        @if($member->voter_card)
                            <a href="{{ asset('storage/' . $member->voter_card) }}" target="_blank" class="btn btn-info btn-sm">View</a>
                        @else
                            N/A
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('members.create', $member->id) }}" class="btn btn-warning btn-sm">Edit</a>

                        <form action="{{ route('members.store', $member->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Are you sure?')" class="btn btn-danger btn-sm">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
